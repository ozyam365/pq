trace.on()

@users = [
  {name:"홍길동", age:25},
  {name:"김철수", age:18},
  {name:"이영희", age:32}
]
//@ -> 변수    (@) -> 객체
@result = (@users)
  .where(age > 20 && name != "김철수")
  .map(name + " (" + age + ")")
  .get()

for $n in @result
  msg.print($n)
end