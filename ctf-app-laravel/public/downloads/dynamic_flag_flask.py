from flask import Flask, request
import hashlib

app = Flask(__name__)

# CONFIGURATION
# This SEED must match the 'flag_seed' set in the Laravel Admin Panel for the challenge.
SEED = "CHANGE_THIS_TO_MATCH_LARAVEL_SEED"

@app.route('/flag', methods=['POST', 'GET'])
def get_flag():
    user_id = request.values.get('user_id')
    
    if not user_id:
        return "Error: Missing user_id parameter", 400
        
    # Generate Flag: SHA256(Seed + User_ID)
    # We take the first 12 chars of the hash to keep it manageable
    raw_hash = hashlib.sha256((SEED + str(user_id)).encode()).hexdigest()
    flag = f"CTF{{{raw_hash[:12]}}}"
    
    return flag

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
