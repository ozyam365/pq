trace.on()

db.con()
@rows = db.query("SELECT * FROM users")
@rows = db.from("users").where("age", ">", 20).get()