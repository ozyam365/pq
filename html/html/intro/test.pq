// sample/intro/test.pq
(@input) = "Hello! 12345 안녕하세요?";

(@only_num) = filter("0~9").on(@input).replace();
(@only_ko)  = filter("가~힣").on(@input).replace();

print "숫자만: " . @only_num; 
print "한글만: " . @only_ko;  

(@price) = "50000";
print "결제금액: " . (@price).money() . "원"; 

(@title) = " <B> [공지] PQ 엔진 v0.7 출시 소식입니다! </B> ";
print (@title).clean().trim().hancut(20);