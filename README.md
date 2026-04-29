 PQ: The Ultimate PHP Query Engine ver 0.6
 
"PHP의 복잡함을 걷어내고, 직관의 골뱅이(@)와 마침표(.)만 남기다."

PQ 엔진은 PHP의 지저분한 문법(->, $, array_map 등)을 현대적이고
직관적인 스크립트 스타일로 변환하여 실행해주는 초경량 PHP 가공 프레임워크입니다.

📜 PQ 헌법 (The Constitution)
제1조 (The Identity): 모든 변수는 @로 시작하며, 객체(Object)는 반드시 (@user).name과 같이 괄호로 명시하여 그 정체성을 보호한다.
제2조 (StrFlow): 모든 문자열 가공은 마침표(.)로 체이닝하며, 반드시 "기준점(.sort)을 먼저 잡고, 그 다음 가공(.cut)한다."
제3조 (Lazy DB): 쿼리는 출력 직전까지 실행을 미룬다(Lazy). db.user.one()과 같이 개발자의 의도가 보일 때만 트리거된다.
제4조 (Safe Import): import "파일명.pq";를 통해 시스템 설정과 모듈을 물리적으로 완벽히 격리한다.
제5조 (Mindset): "에러 날 코드는 아예 안 쓴다. 한눈에 흐름이 안 보이면 버리고 다시 짠다."

✨ 주요 기능 (Key Features)
1. 오브젝트 아이덴티티 (Object Identity)
변수와 객체의 혼선을 막기 위해 객체 접근 시 괄호 문법을 강제합니다.
pq
(@user) = db.users.where("idx=1").one();
print((@user).name); // 객체임을 시각적으로 명시
코드를 사용할 때는 주의가 필요합니다.

3. 문자열 가공 체이닝 (StrFlow)
지저분한 PHP 내장 함수 대신 직관적인 가공 흐름을 제공합니다.
pq
@text = "안녕하세요 PQ엔진입니다";
print(@text.sort("right").hancut(10)); // 결과: ..엔진입니다
print(@user.point.money());            // 결과: 50,000
코드를 사용할 때는 주의가 필요합니다.

5. 직관적인 DB 쿼리 빌더
pq
db.connect();
@rows = db.users.where("age > 20").sort("idx desc").limit(1, 10);
코드를 사용할 때는 주의가 필요합니다.

🛠 설치 및 시작하기 (Quick Start)
본 레포지토리를 다운로드하여 서버에 업로드합니다.
core/config.pq에 DB 정보를 설정합니다.
sample/test.pq 파일을 생성하고 PQ 문법으로 코딩합니다.

브라우저에서 run.php/sample/test.pq로 접속하여 결과를 확인합니다.


### 1. 오브젝트 아이덴티티 (Object Identity)
PQ는 데이터의 정체성을 시각적으로 분리합니다. 시스템이 제공하는 '길'과 사용자가 다루는 '데이터'는 눈으로 구분되어야 합니다.

- **시스템 예약어 (공공재)**: 괄호 없이 직관적으로 연결합니다.
  - `db.user.where().one()`
  - `http.url().send()`
- **사용자 객체 (개인소유)**: 반드시 `(@)`로 감싸 객체임을 선언합니다.
  - `(@row) = db.user.one();` // 대입 시점에 객체임을 선언
  - `print((@row).name);`     // 사용 시점에 객체임을 명시



👨‍💻 Author
ozyam365
"PHP를 더 아름답게, 개발을 더 즐겁게."

⚖️ License
이 프로젝트는 PQ 헌법을 준수하며, 누구나 자유롭게 발전시킬 수 있습니다.

💡 팁
파일 업로드 후 @와 .의 마법을 직접 경험해 보세요.
문의사항이나 아이디어는 Issue 탭에 남겨주세요!


## 🤖 제작 파트너 (The Collaborators)

이 엔진은 인간의 창의력과 AI의 기술력이 결합된 'AI 하이브리드 프로젝트'입니다.

- Human Architect: [ozyam365](https://github.com) (철학 및 설계)
- AI Partners:
  - Gemini: "로직의 헌법을 세우고 StrFlow의 정교함을 다듬다."
  - ChatGPT: "마침표 전쟁을 승리로 이끌고 엔진의 코어를 빌드하다."

> "두 AI 파트너와 밤새 토론하며 PHP의 한계를 뛰어넘는 문법을 설계했습니다."

