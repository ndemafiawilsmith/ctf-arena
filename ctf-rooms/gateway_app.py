import os
import hashlib
from flask import Flask, request, render_template_string

app = Flask(__name__)

# ==========================================
# CONFIGURATION
# ==========================================
SEED = "CTF_ARENA_MASTER_SEED"
SHARED_BASE = "/shared"

# Paths to shared volumes where flags should be written
# Ensure these directories are mounted in docker-compose
FLAG_PATHS = {
    'sqli': os.path.join(SHARED_BASE, 'sqli', 'flag.txt'),
    'idor': os.path.join(SHARED_BASE, 'idor', 'flag.txt'),
    'rce':  os.path.join(SHARED_BASE, 'rce', 'flag.txt')
}

# ==========================================
# TEMPLATES (EMBEDDED)
# ==========================================

STYLES = """
<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto+Mono:wght@400;700&display=swap');

    body {
        background-color: #050505;
        color: #e0e0e0;
        font-family: 'Roboto Mono', monospace;
        background-image: radial-gradient(circle at 50% 50%, #111 0%, #000 100%);
    }

    h1, h2, h3, .navbar-brand {
        font-family: 'Orbitron', sans-serif;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .neon-text-blue {
        color: #00f3ff;
        text-shadow: 0 0 5px #00f3ff, 0 0 10px #00f3ff;
    }

    .neon-text-pink {
        color: #ff00ff;
        text-shadow: 0 0 5px #ff00ff, 0 0 10px #ff00ff;
    }

    .cyber-card {
        background: rgba(20, 20, 20, 0.9);
        border: 1px solid #333;
        border-left: 5px solid #00f3ff;
        box-shadow: 0 0 15px rgba(0, 243, 255, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .cyber-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 25px rgba(0, 243, 255, 0.2);
    }

    .cyber-btn {
        background: transparent;
        border: 2px solid #00f3ff;
        color: #00f3ff;
        font-family: 'Orbitron', sans-serif;
        text-transform: uppercase;
        padding: 10px 20px;
        transition: all 0.3s;
    }

    .cyber-btn:hover {
        background: #00f3ff;
        color: #000;
        box-shadow: 0 0 15px #00f3ff;
    }

    .cyber-input {
        background: #111;
        border: 1px solid #444;
        color: #00f3ff;
        font-family: 'Roboto Mono', monospace;
    }
    
    .cyber-input:focus {
        background: #111;
        border-color: #ff00ff;
        color: #ff00ff;
        box-shadow: 0 0 10px rgba(255, 0, 255, 0.3);
    }

    /* Hero Section */
    .hero-section {
        border-bottom: 2px solid #ff00ff;
        padding: 3rem 0;
        margin-bottom: 2rem;
        background: repeated-linear-gradient(
            45deg,
            rgba(0,0,0,0) 0,
            rgba(0,0,0,0) 10px,
            rgba(20, 20, 20, 1) 10px,
            rgba(20, 20, 20, 1) 20px
        );
    }
    
    .status-badge {
        font-size: 0.8em;
        padding: 2px 8px;
        border: 1px solid #444;
    }
</style>
"""

# BASE HTML STRUCTURE
BASE_TEMPLATE = """
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTF_ARENA // GATEWAY</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    {{ styles|safe }}
</head>
<body>

    <!-- HERO SECTION (Branding) -->
    <div class="container-fluid hero-section text-center">
        <h1 class="display-4 neon-text-pink">CTF_ARENA <span style="font-size:0.5em; vertical-align:middle; border:1px solid #ff00ff; padding: 2px 5px;">2027</span></h1>
        <p class="lead text-muted">Welcome to the proving grounds.</p>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container">
        {{ content|safe }}
    </div>

    <footer class="text-center mt-5 mb-3 text-secondary" style="font-size: 0.8rem;">
        <p>SYSTEM STATUS: <span style="color:#0f0">ONLINE</span> // NODE: GATEWAY-01</p>
    </footer>

</body>
</html>
"""

# STATE A: LANDING PAGE
LANDING_CONTENT = """
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card cyber-card p-4">
            <div class="card-body text-center">
                <h3 class="mb-4 neon-text-blue">Identify Yourself</h3>
                
                {% if error %}
                <div class="alert alert-danger" role="alert" style="background:#300; border:1px solid red; color:red;">
                    {{ error }}
                </div>
                {% endif %}

                <form method="POST" action="/">
                    <div class="mb-4">
                        <label for="user_id" class="form-label text-start w-100">User Callchian / ID</label>
                        <input type="text" class="form-control cyber-input form-control-lg text-center" id="user_id" name="user_id" placeholder="ENTER_ID" required>
                    </div>
                    <button type="submit" class="btn cyber-btn w-100">INITIALIZE CONNECTION</button>
                </form>
            </div>
        </div>
    </div>
</div>
"""

# STATE B: DASHBOARD
DASHBOARD_CONTENT = """
<div class="row mb-4">
    <div class="col-12 text-center">
        <h2 class="mb-2">Mission Dashboard</h2>
        <p class="text-muted">Operative: <span class="neon-text-blue">{{ user_id }}</span></p>
        {% if msg %}
        <div class="alert alert-success" style="background:#030; border:1px solid #0f0; color:#0f0; display:inline-block;">
            {{ msg }}
        </div>
        {% endif %}
    </div>
</div>

<div class="row g-4">
    <!-- Challenge 1: SQLi -->
    <div class="col-md-4">
        <div class="card cyber-card h-100" style="border-left-color: #ff00ff;">
            <div class="card-body d-flex flex-column">
                <h4 class="card-title neon-text-pink">Target: SQL_LOGIN</h4>
                <p class="card-text text-secondary mt-2">Bypass the authentication mechanism to retrieve administrative credentials.</p>
                <div class="mt-auto">
                    <p class="status-badge text-warning mb-3">DIFFICULTY: LOW</p>
                    <a href="http://{{ host_ip }}:8001" target="_blank" class="btn cyber-btn w-100">LAUNCH TARGET</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Challenge 2: IDOR -->
    <div class="col-md-4">
        <div class="card cyber-card h-100" style="border-left-color: #eebb00;">
            <div class="card-body d-flex flex-column">
                <h4 class="card-title" style="color:#eebb00; text-shadow:0 0 5px #eebb00;">Target: IDOR_PROFILE</h4>
                <p class="card-text text-secondary mt-2">Exploit Insecure Direct Object References to access unauthorized profile data.</p>
                <div class="mt-auto">
                    <p class="status-badge text-warning mb-3">DIFFICULTY: MEDIUM</p>
                    <a href="http://{{ host_ip }}:8002" target="_blank" class="btn cyber-btn w-100">LAUNCH TARGET</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Challenge 3: RCE -->
    <div class="col-md-4">
        <div class="card cyber-card h-100" style="border-left-color: #ff0000;">
            <div class="card-body d-flex flex-column">
                <h4 class="card-title" style="color:#ff0000; text-shadow:0 0 5px #ff0000;">Target: RCE_PING</h4>
                <p class="card-text text-secondary mt-2">Achieve Remote Code Execution through input sanitization failure.</p>
                <div class="mt-auto">
                    <p class="status-badge text-danger mb-3">DIFFICULTY: HIGH</p>
                    <a href="http://{{ host_ip }}:8003" target="_blank" class="btn cyber-btn w-100">LAUNCH TARGET</a>
                </div>
            </div>
        </div>
    </div>
</div>
"""

# ==========================================
# APP LOGIC
# ==========================================

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        user_id = request.form.get('user_id', '').strip()
        
        if not user_id:
            # Render Landing with error
            content = render_template_string(LANDING_CONTENT, error="User ID is required.")
            return render_template_string(BASE_TEMPLATE, styles=STYLES, content=content)

        # 1. Calculate Flags
        try:
            flag_sqli = hashlib.sha256(f"{SEED}SQLi{user_id}".encode()).hexdigest()
            flag_idor = hashlib.sha256(f"{SEED}IDOR{user_id}".encode()).hexdigest()
            flag_rce  = hashlib.sha256(f"{SEED}RCE{user_id}".encode()).hexdigest()
        except Exception as e:
            content = render_template_string(LANDING_CONTENT, error=f"Hashing Error: {e}")
            return render_template_string(BASE_TEMPLATE, styles=STYLES, content=content)

        # 2. Provision Flags (Fail Gracefully)
        prov_msg = ""
        try:
            # Helper to write flag
            def write_flag(path, content):
                # Ensure directory exists (handled by Docker usually, but good to be safe)
                dir_path = os.path.dirname(path)
                if not os.path.exists(dir_path):
                    # We can try to create it, but if it's a volume issue, it might fail.
                    # In a container, we usually assume the mount exists or we create the dir.
                    os.makedirs(dir_path, exist_ok=True)
                
                with open(path, 'w') as f:
                    f.write(content)

            write_flag(FLAG_PATHS['sqli'], flag_sqli)
            write_flag(FLAG_PATHS['idor'], flag_idor)
            write_flag(FLAG_PATHS['rce'],  flag_rce)

        except Exception as e:
            # If provisioning fails, we log it but don't crash. 
            # We show it in the dashboard so the user knows something is wrong locally.
            prov_msg = f"WARNING: Flag provisioning failed: {str(e)}. (Are shared volumes mounted?)"
        
        # 3. Display Dashboard
        # Attempt to guess host IP or just use 'localhost' for links
        # For a local VM, the user probably accesses via VM IP. 
        # JavaScript could detect 'window.location.hostname', but for simplicity we'll just put window.location.hostname in the link via JS or use a placeholder
        # We will use window.location.hostname via client-side template injection or just simple python injection.
        
        # NOTE: Since we are running in a container, we don't know the user's browser IP easily.
        # We'll use a Javascript trick in the link: href="http://' + window.location.hostname + ':8001"
        # To make it cleaner in HTML, we can use a script to rewrite links.
        # OR we just assume localhost if not specified.
        # Let's use the JS approach for robustness.
        
        # Re-writing the DASHBOARD_CONTENT slightly to handle dynamic Host IP
        dashboard_html = render_template_string(DASHBOARD_CONTENT, user_id=user_id, msg=prov_msg, host_ip="")
        
        # Inject JS to fix ports
        js_fix = """
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var links = document.querySelectorAll("a[href*=':800']");
                links.forEach(function(link) {
                    var port = link.href.split(':').pop();
                    link.href = window.location.protocol + "//" + window.location.hostname + ":" + port;
                });
            });
        </script>
        """
        
        final_content = dashboard_html + js_fix
        return render_template_string(BASE_TEMPLATE, styles=STYLES, content=final_content)

    else:
        # GET Request -> Landing Page
        content = render_template_string(LANDING_CONTENT)
        return render_template_string(BASE_TEMPLATE, styles=STYLES, content=content)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=80)
