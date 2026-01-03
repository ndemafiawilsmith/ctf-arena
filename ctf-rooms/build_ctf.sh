#!/bin/bash

# ==========================================
# CTF Build Script v5 (Anti-Crash Edition)
# ==========================================

set -e

echo "[+] Starting CTF Build Process..."

# 1. CRITICAL FIX: Force Delete All Containers
# We use raw docker commands because 'docker-compose down' crashes on this error.
echo "[!] Nuke Phase: Removing all existing containers to fix 'ContainerConfig' error..."
if [ -n "$(sudo docker ps -aq)" ]; then
    sudo docker rm -f $(sudo docker ps -aq)
fi
echo "[+] Containers cleared."

# 2. Clean Slate & Directory Structure
ROOT_DIR="ctf_bundle"
if [ -d "$ROOT_DIR" ]; then
    echo "[-] Removing existing $ROOT_DIR directory..."
    rm -rf "$ROOT_DIR"
fi
mkdir -p "$ROOT_DIR"
cd "$ROOT_DIR"

# Create subdirectories
mkdir -p shared/sqli shared/idor shared/rce shared/static
mkdir -p gateway sql_login idor_profile rce_ping

# Set permissions (Critical for Docker)
chmod -R 777 shared
echo "[+] Directory structure created."

# 3. Download Offline Bootstrap
echo "[+] Downloading Bootstrap for offline usage..."
if curl -s -L "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" -o shared/static/bootstrap.min.css; then
    echo "[+] Bootstrap downloaded."
else
    echo "[!] Warning: Offline Bootstrap download failed. UI will be unstyled without internet."
    touch shared/static/bootstrap.min.css
fi

# ==========================================
# SHARED CSS THEME (Cyberpunk + Footer)
# ==========================================
cat <<CSS > shared/static/custom.css
@import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;700&display=swap');
:root {
    --neon-green: #00ff41;
    --neon-purple: #bd00ff;
    --neon-red: #ff003c;
    --dark-bg: #050505;
    --panel-bg: rgba(20,20,20,0.95);
}
body {
    background-color: var(--dark-bg);
    color: #e0e0e0;
    font-family: 'Rajdhani', sans-serif;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
.content-wrapper { flex: 1; }
.navbar { background: rgba(0,0,0,0.9); border-bottom: 1px solid #333; }
.card {
    background: var(--panel-bg);
    border: 1px solid #333;
    box-shadow: 0 0 15px rgba(0,0,0,0.5);
}
.card-header {
    background: rgba(0,0,0,0.5);
    font-weight: bold;
    letter-spacing: 2px;
    border-bottom: 1px solid #333;
}
.btn-primary {
    background-color: var(--neon-green);
    border: none;
    color: #000;
    font-weight: bold;
    text-transform: uppercase;
}
.btn-primary:hover { background-color: #00cc33; color: #000; box-shadow: 0 0 10px var(--neon-green); }
.form-control {
    background: #111;
    border: 1px solid #333;
    color: var(--neon-green);
}
.form-control:focus {
    background: #000;
    border-color: var(--neon-green);
    color: var(--neon-green);
    box-shadow: 0 0 5px rgba(0, 255, 65, 0.5);
}
/* Footer Styling */
footer {
    text-align: center;
    padding: 20px;
    margin-top: auto;
    border-top: 1px solid #333;
    color: #666;
    font-size: 0.9rem;
    letter-spacing: 1px;
    background: #000;
}
footer span { color: var(--neon-green); font-weight: bold; }

/* Theme Accents */
.theme-sqli .card { border-top: 3px solid var(--neon-green); }
.theme-sqli .text-accent { color: var(--neon-green); }
.theme-idor .card { border-top: 3px solid var(--neon-purple); }
.theme-idor .text-accent { color: var(--neon-purple); }
.theme-rce .card { border-top: 3px solid var(--neon-red); }
.theme-rce .text-accent { color: var(--neon-red); }
CSS

# ==========================================
# GATEWAY SERVICE
# ==========================================
echo "[+] Configuring Gateway..."

cat <<EOF > gateway/requirements.txt
flask
EOF

cat <<EOF > gateway/Dockerfile
FROM python:3.9-alpine
WORKDIR /app
COPY . .
RUN pip install -r requirements.txt
CMD ["python", "app.py"]
EOF

cat <<'PYTHON_EOF' > gateway/app.py
import os
import hashlib
from flask import Flask, request, render_template_string

app = Flask(__name__)

# CONFIGURATION
SHARED_BASE = "/shared"

CHALLENGE_CONFIG = {
    'sqli': {
        'seed': 'qwerty_sqli_2025',
        'path': os.path.join(SHARED_BASE, 'sqli', 'flag.txt')
    },
    'idor': {
        'seed': 'qwerty_idor_2025',
        'path': os.path.join(SHARED_BASE, 'idor', 'flag.txt')
    },
    'rce': {
        'seed': 'qwerty_rce_2025',
        'path': os.path.join(SHARED_BASE, 'rce', 'flag.txt')
    }
}


TEMPLATE = """
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTF_ARENA // GATEWAY</title>
    <link href="/static/bootstrap.min.css" rel="stylesheet">
    <link href="/static/custom.css" rel="stylesheet">
    <style>
        .hero { padding: 80px 0; text-align: center; }
        .hero h1 { font-size: 3.5rem; font-weight: 700; margin-bottom: 1rem; }
        .input-cyber { background: #111; border: 1px solid #333; color: #00ff41; padding: 10px; text-align: center; font-size: 1.2rem; width: 300px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">&gt;_ CTF_ARENA</a>
        </div>
    </nav>

    <div class="container content-wrapper">
        {% if not dashboard %}
        <div class="hero">
            <h1 class="text-white">CAPTURE <span style="color:#00ff41">THE FLAG</span></h1>
            <p class="text-muted mb-5">AUTHENTICATE TO BEGIN OPERATION</p>
            {% if error %}<div class="alert alert-danger mx-auto w-50">{{ error }}</div>{% endif %}
            <form method="POST" action="/">
                <input type="text" name="user_id" class="input-cyber" placeholder="ENTER CODENAME" required>
                <br><br>
                <button type="submit" class="btn btn-primary px-5">INITIALIZE</button>
            </form>
        </div>
        {% else %}
        <div class="row mt-5 text-center">
            <div class="col-12 mb-4">
                <h2 class="text-white">OPERATIVE: <span style="color:#00ff41">{{ user_id }}</span></h2>
                <div class="alert alert-success d-inline-block p-2 py-1">SYSTEM ONLINE</div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 theme-sqli">
                    <div class="card-body d-flex flex-column">
                        <h3 class="text-accent">01 // SQL_LOGIN</h3>
                        <p class="text-muted">Target: Corporate Login Portal.</p>
                        <a href="http://{{ host }}:8001" target="_blank" class="btn btn-outline-success mt-auto w-100">DEPLOY</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 theme-idor">
                    <div class="card-body d-flex flex-column">
                        <h3 class="text-accent">02 // IDOR_VIEW</h3>
                        <p class="text-muted">Target: Profile Manager.</p>
                        <a href="http://{{ host }}:8002" target="_blank" class="btn btn-outline-info mt-auto w-100" style="color:#bd00ff; border-color:#bd00ff">DEPLOY</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 theme-rce">
                    <div class="card-body d-flex flex-column">
                        <h3 class="text-accent">03 // RCE_PING</h3>
                        <p class="text-muted">Target: Network Diagnostics.</p>
                        <a href="http://{{ host }}:8003" target="_blank" class="btn btn-outline-danger mt-auto w-100">DEPLOY</a>
                    </div>
                </div>
            </div>
        </div>
        {% endif %}
    </div>

    <footer>
        Designed by <span>Cyberwilsmith</span>
    </footer>
    
    <script>
    document.addEventListener('DOMContentLoaded',function(){
        document.querySelectorAll('a[href*=":800"]').forEach(function(l){
            l.href=window.location.protocol+'//'+window.location.hostname+':'+l.href.split(':').pop();
        });
    });
    </script>
</body>
</html>
"""

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        user_id = request.form.get('user_id', '').strip()

        if not user_id:
            return render_template_string(
                TEMPLATE,
                dashboard=False,
                error="User ID required"
            )

        try:
            def gen_flag(seed, user_id):
                raw = hashlib.sha256(
                    f"{seed}{user_id}".encode('utf-8')
                ).hexdigest()
                return f"CTF{{{raw[:12]}}}"

            for chal, cfg in CHALLENGE_CONFIG.items():
                os.makedirs(os.path.dirname(cfg['path']), exist_ok=True)
                flag = gen_flag(cfg['seed'], user_id)

                with open(cfg['path'], 'w') as f:
                    f.write(flag)

        except Exception as e:
            return render_template_string(
                TEMPLATE,
                dashboard=False,
                error=str(e)
            )

        return render_template_string(
            TEMPLATE,
            dashboard=True,
            user_id=user_id,
            host="localhost"
        )

    return render_template_string(TEMPLATE, dashboard=False)


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
PYTHON_EOF

# ==========================================
# CHALLENGE 1: SQL Injection
# ==========================================
echo "[+] Configuring SQLi Service..."
cat <<EOF > sql_login/requirements.txt
flask
EOF
cat <<EOF > sql_login/Dockerfile
FROM python:3.9-alpine
WORKDIR /app
COPY . .
RUN pip install -r requirements.txt
CMD ["python", "app.py"]
EOF

cat <<'PYTHON_EOF' > sql_login/app.py
import sqlite3, os
from flask import Flask, request, render_template_string

app = Flask(__name__)
DB_NAME = 'users.db'
FLAG_FILE = '/shared/sqli/flag.txt'

def get_flag():
    if os.path.exists(FLAG_FILE): return open(FLAG_FILE).read().strip()
    return "CTF{ERR_NO_PROVISION}"

def init_db():
    conn = sqlite3.connect(DB_NAME)
    c = conn.cursor()
    c.execute('CREATE TABLE IF NOT EXISTS users (username TEXT, password TEXT)')
    c.execute("INSERT INTO users VALUES ('admin', 'REDACTED')")
    c.execute("INSERT INTO users VALUES ('guest', 'guest')")
    conn.commit()
    conn.close()

if not os.path.exists(DB_NAME): init_db()

HTML = """
<!DOCTYPE html>
<html>
<head>
    <title>Secure Corp | Login</title>
    <link href="/static/bootstrap.min.css" rel="stylesheet">
    <link href="/static/custom.css" rel="stylesheet">
</head>
<body class="theme-sqli">
    <div class="content-wrapper d-flex align-items-center justify-content-center">
        <div class="card" style="width: 400px;">
            <div class="card-header text-accent text-center">
                🔒 SECURE CORP PORTAL
            </div>
            <div class="card-body">
                {% if success %}
                    <div class="alert alert-success border-success bg-dark text-success text-center">
                        <h4>ACCESS GRANTED</h4>
                        <p class="mb-0">SECRET: <strong>{{ flag }}</strong></p>
                    </div>
                    <a href="/" class="btn btn-sm btn-outline-light w-100">LOGOUT</a>
                {% else %}
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted">USERNAME</label>
                            <input type="text" name="username" class="form-control" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">PASSWORD</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">AUTHENTICATE</button>
                        </div>
                    </form>
                    {% if error %}
                        <div class="alert alert-danger mt-3 py-2 text-center border-danger bg-dark text-danger">{{ error }}</div>
                    {% endif %}
                {% endif %}
            </div>
            <div class="card-footer text-center text-muted" style="font-size:0.8rem">
                Authorized Personnel Only
            </div>
        </div>
    </div>
    <footer>
        Designed by <span>Cyberwilsmith</span>
    </footer>
</body>
</html>
"""

@app.route('/', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        u = request.form.get('username')
        p = request.form.get('password')
        conn = sqlite3.connect(DB_NAME)
        c = conn.cursor()
        try:
            # Vulnerability
            c.execute(f"SELECT * FROM users WHERE username = '{u}' AND password = '{p}'")
            user = c.fetchone()
            if user:
                flag = get_flag() if user[0] == 'admin' else "User level access only."
                return render_template_string(HTML, success=True, flag=flag)
            return render_template_string(HTML, error="Invalid Credentials")
        except Exception as e:
            return render_template_string(HTML, error="DB Error (Hint: Check your syntax)")
        finally:
            conn.close()
    return render_template_string(HTML)

if __name__ == '__main__': app.run(host='0.0.0.0', port=5000)
PYTHON_EOF


# ==========================================
# CHALLENGE 2: IDOR
# ==========================================
echo "[+] Configuring IDOR Service..."
cat <<EOF > idor_profile/requirements.txt
flask
EOF
cat <<EOF > idor_profile/Dockerfile
FROM python:3.9-alpine
WORKDIR /app
COPY . .
RUN pip install -r requirements.txt
CMD ["python", "app.py"]
EOF

cat <<'PYTHON_EOF' > idor_profile/app.py
import os
from flask import Flask, request, render_template_string

app = Flask(__name__)
FLAG_FILE = '/shared/idor/flag.txt'

def get_flag():
    if os.path.exists(FLAG_FILE): return open(FLAG_FILE).read().strip()
    return "CTF{ERR}"

HTML = """
<!DOCTYPE html>
<html>
<head>
    <title>Employee Directory</title>
    <link href="/static/bootstrap.min.css" rel="stylesheet">
    <link href="/static/custom.css" rel="stylesheet">
</head>
<body class="theme-idor">
    <nav class="navbar navbar-dark mb-4">
        <div class="container">
            <span class="navbar-brand">👥 STAFF_VIEWER v1.0</span>
            <span class="text-muted">Logged in as: Guest</span>
        </div>
    </nav>
    <div class="container content-wrapper">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header text-accent d-flex justify-content-between">
                <span>EMPLOYEE PROFILE</span>
                <span>ID: #{{ uid }}</span>
            </div>
            <div class="card-body text-center py-5">
                <div style="font-size:4rem; margin-bottom:1rem;">👤</div>
                <h2 class="text-white">{{ username }}</h2>
                <p class="text-muted">Role: {{ role }}</p>
                <hr style="border-color:#333">
                <div class="bg-dark p-3 border border-secondary rounded text-start">
                    <small class="text-muted d-block mb-1" style="color:#fff;">CONFIDENTIAL DATA:</small>
                    <code style="color:var(--neon-purple); font-size:1.1em">{{ secret }}</code>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="/?id=10" class="btn btn-sm btn-outline-secondary">Load My Profile</a>
            </div>
        </div>
    </div>
    <footer>
        Designed by <span>Cyberwilsmith</span>
    </footer>
</body>
</html>
"""

@app.route('/', methods=['GET'])
def index():
    uid = request.args.get('id', '10')
    if uid == '1':
        return render_template_string(HTML, uid="001", username="ADMINISTRATOR", role="SYSTEM_ROOT", secret=get_flag())
    elif uid == '10':
        return render_template_string(HTML, uid="010", username="GUEST USER", role="VISITOR", secret="[REDACTED] - Insufficient Privileges")
    else:
        return render_template_string(HTML, uid=uid, username="UNKNOWN", role="N/A", secret="USER NOT FOUND")

if __name__ == '__main__': app.run(host='0.0.0.0', port=5000)
PYTHON_EOF


# ==========================================
# CHALLENGE 3: RCE
# ==========================================
echo "[+] Configuring RCE Service..."
cat <<EOF > rce_ping/requirements.txt
flask
EOF
cat <<EOF > rce_ping/Dockerfile
FROM python:3.9-alpine
WORKDIR /app
COPY . .
RUN apk add --no-cache iputils
RUN pip install -r requirements.txt
CMD ["python", "app.py"]
EOF

cat <<'PYTHON_EOF' > rce_ping/app.py
import os
import shutil
from flask import Flask, request, render_template_string

app = Flask(__name__)

# Symlink flag for RCE easy access
SOURCE_FLAG = '/shared/rce/flag.txt'
DEST_FLAG = '/app/flag.txt'

# We copy/symlink it on every request in case it was just provisioned
def ensure_flag():
    if os.path.exists(SOURCE_FLAG):
        if os.path.exists(DEST_FLAG): os.remove(DEST_FLAG)
        os.symlink(SOURCE_FLAG, DEST_FLAG)

HTML = """
<!DOCTYPE html>
<html>
<head>
    <title>NetTool | Ping</title>
    <link href="/static/bootstrap.min.css" rel="stylesheet">
    <link href="/static/custom.css" rel="stylesheet">
</head>
<body class="theme-rce">
    <div class="container content-wrapper mt-5">
        <div class="card border-danger">
            <div class="card-header text-danger bg-dark">
                ⚠️ DANGEROUS NETWORK UTILITY
            </div>
            <div class="card-body">
                <h5 class="card-title text-white">HOST REACHABILITY TEST</h5>
                <p class="card-text text-muted">Enter target IP to verify connectivity.</p>
                <form method="POST" class="d-flex gap-2">
                    <input type="text" name="ip" class="form-control" placeholder="127.0.0.1" style="border-color:#550000">
                    <button type="submit" class="btn btn-outline-danger">EXECUTE</button>
                </form>
            </div>
        </div>

        {% if output %}
        <div class="card mt-4 bg-black border-secondary">
            <div class="card-header py-1 text-muted" style="font-size:0.8rem">STDOUT</div>
            <div class="card-body p-0">
                <pre class="m-0 p-3 text-success" style="font-family:monospace;">{{ output }}</pre>
            </div>
        </div>
        {% endif %}
    </div>
    <footer>
        Designed by <span>Cyberwilsmith</span>
    </footer>
</body>
</html>
"""

@app.route('/', methods=['GET', 'POST'])
def index():
    ensure_flag() # Update flag symlink
    out = ""
    if request.method == 'POST':
        ip = request.form.get('ip', '')
        # Vulnerability
        try: out = os.popen(f"ping -c 2 {ip}").read()
        except Exception as e: out = str(e)
    return render_template_string(HTML, output=out)

if __name__ == '__main__': app.run(host='0.0.0.0', port=5000)
PYTHON_EOF

# ==========================================
# DOCKER COMPOSE
# ==========================================
echo "[+] Generating docker-compose.yml..."

cat <<EOF > docker-compose.yml
version: '3'
services:
  gateway:
    build: ./gateway
    ports: ["80:5000"]
    volumes:
      - ./shared:/shared
      - ./shared/static:/app/static
    restart: always

  sql_login:
    build: ./sql_login
    ports: ["8001:5000"]
    volumes:
      - ./shared:/shared
      - ./shared/static:/app/static
    restart: always

  idor_profile:
    build: ./idor_profile
    ports: ["8002:5000"]
    volumes:
      - ./shared:/shared
      - ./shared/static:/app/static
    restart: always

  rce_ping:
    build: ./rce_ping
    ports: ["8003:5000"]
    volumes:
      - ./shared:/shared
      - ./shared/static:/app/static
    restart: always
EOF

echo "[+] Build Complete."
echo "--------------------------------------------------------"
echo "To Launch: cd ctf_bundle && sudo docker-compose up --build -d"
echo "--------------------------------------------------------"