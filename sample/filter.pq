db.connect();

@res = db.users.filter(fn(@row){
    return @row.age > 30;
});

print(@res);