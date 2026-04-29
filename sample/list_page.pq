print("START");

db.connect();

@res = list("users").page(1,10);

print(@res);