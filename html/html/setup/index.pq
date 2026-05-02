// 수정 후 index.pq 모습 (첫 줄에 아무것도 없어야 함)
(@user) = db.one("SELECT 'Architect' as name, 'Investigator' as role");
print "<h4>수사관 정보</h4>";
print "이름: " . (@user).name;