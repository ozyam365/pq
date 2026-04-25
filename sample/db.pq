trace.on()

db.con()

@rows = db.query("SELECT * FROM users")

for @r in @rows
    msg.print(@r.name)
end