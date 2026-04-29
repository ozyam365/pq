db.connect();

@res = db.users.pluck("name");

print(@res);