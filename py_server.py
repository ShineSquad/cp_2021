from flask import Flask
from flaskext.mysql import MySQL
import json

app = Flask(__name__)
mysql = MySQL()

app.config["MYSQL_DATABASE_USER"] = "moodle"
app.config["MYSQL_DATABASE_PASSWORD"] = "X6k0cr6xNe7p"
app.config["MYSQL_DATABASE_DB"] = "moodle"
app.config["MYSQL_DATABASE_HOST"] = "85.208.208.61"

mysql.init_app(app)

@app.route("/")
def index():
	return "userinfo"

@app.route("/userinfo/<id>")
def userinfo(id):
	info = {
		"username": "",
		"logs": [],
		"xp": 0,
		"lvl": 0
	}
	conn = mysql.connect()
	cursor = conn.cursor()

	cursor.execute("SELECT `username` FROM `mdl_user` WHERE `mdl_user`.`id` = {0}".format(id))
	data = cursor.fetchone()

	if data is None:
		return json.dumps({
			"error": True,
			"message": "user id={0}, not found".format(id)	
		})
	info["username"] = data[0]

	cursor.execute("SELECT `xp`, `lvl` FROM `mdl_block_xp` WHERE `userid` = " + id)
	data = cursor.fetchone()

	if data is None:
		return json.dumps({
			"error": True,
			"message": "user id={0}, have no xp or lvl fields".format(id)	
		})

	info["xp"] = data[0]
	info["lvl"] = data[1]

	cursor.execute("SELECT `eventname`, `xp`, `time` FROM `mdl_block_xp_log` WHERE `userid` = " + id)
	data = cursor.fetchall()
	
	for d in data:
		info["logs"].append({
			"type": d[0],
			"xp": d[1],
			"ts": d[2]	
		})
	
	return json.dumps({
		"error": False,
		"data": info
	})

if __name__ == "__main__":
	app.run(debug=False, port=8080, host="0.0.0.0")