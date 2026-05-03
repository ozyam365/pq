pq is a DSL for writing database logic in a readable way.

It separates:
- raw values (@)
- object access (@())

Example:

@res = db.users.where("age > 20").get();

foreach(@res as @row):
  print((@row).name);
endforeach;

🚀PQ 엔진소개
✨PQ engine VERSION 0.7 베타 버젼이라 작업 하는데로 올리고 있어서 깨진것도 있으니 잘 보시고 참고만 하시면 좋을껍니다.

"PQ엔진은 PHP+QUERY / PHP+QUICK" 이 두가지 의미를 축약해서 [PQ] 라 하게 되었습니다.

 "그동안 사용했던 php의 편리성, jquery의 편리성을 합쳐서 웹개발을 좀더 편리하게 할수 없을까?"라는 고민끝에 만들게 되었습니다.
 메뉴얼은 만들면서 작업중 입니다~    https://pq365.mycafe24.com/intro

 
PHP의 복잡함을 걷어내고, 직관성을 유지하는데 촛점을 맞춥니다.
변수는 @, 대기변수 @
객체는 (@)
배열은 []
체이닝 .
pq의 시작 : 문서내에 [[pq구문작성]]
함수 fn
php include "파일명"; -> pq import "파일명";
php <?=$aaa?> -> pq [[=@aaa]]
시스템 예약어 db / http / iot / file / form 등 15개이상에서는 객체를 . 으로 연결하여 사용자 객체와 구분합니다.
http.url(@target).send();
db.user.where("a > 20"); 
(@aaa).where("a > 20");    <--- 사용자의 객체
다만  변수에 접근해서 오브젝트화 시키는건 금지 문법입니다.  
@aaa.name-> 금지   /  @aaa.hcut(20);허용  합니다.
@aaa변수의 값을 가지고 함수에서 쓸수는 있습니다.
@aaa를 더 폭넓게 쓰시려면 객체로 전환합니다 (@aaa).name.hcut(20); 가능한 문법입니다.
이 정도 공식만 알고 있으면 기존 개발자들은 쉽게 적응 할 수 있습니다.		

👉pq는 php v8 기반 위에서 돌아가는 엔진입니다.
목표는 " 짧고, 빠르고, 편하고, 직관적인 언어를 써서 빠르게 개발한다. "
https://github.com/ozyam365/pq/
에서 다운로드 및 확인 가능합니다.
📍 PQ 헌법
제1조 The Identity
모든 변수는 @로 시작하며, 객체(Object)는 반드시 (@user).name과 같이 괄호로 명시하여 그 정체성을 보호한다.

※ 괄호 보호막은 변수가 객체로 승격되었음을 의미합니다.
제2조 StrFlow
모든 문자열 가공은 마침표(.)로 체이닝하며, 반드시 "기준점(.sort)을 먼저 잡고, 그 다음 가공(.cut)한다."

제3조 Lazy DB
쿼리는 출력 직전까지 실행을 미룬다(Lazy). db.user.one()과 같이 개발자의 의도가 보일 때만 트리거된다.

제4조 Physical Isolation
import "파일명.pq";를 통해 시스템 설정과 모듈을 물리적으로 완벽히 격리한다.

제5조 The Flow
"에러 날 코드는 아예 안 쓴다. 한눈에 흐름이 안 보이면 버리고 다시 짠다."

🤖 제작 파트너 (The Collaborators)
이 엔진은 인간의 창의력과 AI의 기술력이 결합된 'AI 하이브리드 프로젝트'입니다.

Human Architect: ozones (철학 및 설계)

AI Partners:
Gemini: "로직의 헌법을 세우고 StrFlow의 정교함을 다듬다."
ChatGPT: "마침표 전쟁을 승리로 이끌고 엔진의 코어를 빌드하다."
"두 AI 파트너와 밤새 토론하며 PHP의 한계를 뛰어넘는 문법을 설계했습니다."

 License : 이 프로젝트는 PQ 헌법을 준수하며, 누구나 자유롭게 발전시킬 수 있습니다.
