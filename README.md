# 🚀 PQ Engine (v0.7 Beta)
> **"PHP의 복잡함을 걷어 내고 쉽고 편리안 엔진을 장착한다."**


**PQ(PHP+QUERY / PHP+QUICK)** 엔진은 
"PHP+QUERY / PHP+QUICK" 이 두가지 의미를 축약해서 [PQ] 라 하게 되었습니다.

PHP의 복잡함을 걷어내고, 직관성을 유지하는데 촛점을 맞춥니다.
변수는 @
객체는 (@)
배열은 ([])
체이닝 .
이 작은 공식만 알고 있으면 기존 개발자들은 쉽게 적응 할 수 있습니다.		

👉pq는 php v8 기반 위에서 돌아가는 엔진입니다.


---

## 📍 PQ 헌법 (The Constitution)
코드의 흐름이 곧 법입니다. PQ는 아래 5가지 원칙을 준수합니다.

| **제1조** | **The Identity** | 모든 변수는 `@`, 객체는 `(@ user)`로 정체성을 보호한다. |
| **제2조** | **StrFlow** | 가공은 마침표(`.`)로 체이닝하며, 기준점(`.sort`)을 먼저 잡는다. |
| **제3조** | **Lazy DB** | 쿼리는 실행을 미루며, 의도가 명확할 때만 트리거된다. |
| **제4조** | **Isolation** | `import`를 통해 시스템과 모듈을 물리적으로 완벽히 격리한다. |
| **제5조** | **The Flow** | 한눈에 흐름이 안 보이면 버리고 다시 짠다. |

---

## ⚡ 주요 특징 (Why PQ?)

*   **실전형 무장:**  중소규모 프로젝트를 위한 날렵한 '구축함'.
*   **보안 수사관:** `form.safe()` 한 줄로 끝내는 강력한 보안 방어막 (준비중).
*   **AI 하이브리드:** Gemini & ChatGPT와 밤새 토론하며 설계한 현대적 문법.

---

## 💻 맛보기 (Syntax Sample)



```sample/bit.pq
@base = "https://api.coinbase" . ".com";
@path = "/v2/prices/BTC-USD/spot";
@target = @base . @path;

@res = http.url(@target).send();

print("--- 데이터 확인 ---");
print(@res); 

if(@res.data) {
    print("현재 비트코인 시세: $" . @res.data.amount);
}



``` sample/insert.pq
db.connect();

@record = []; 
@record["name"] = "홍길동2";
@record["age"] = 32;

//// 결과는 그냥 @ 변수에 담으면 됩니다. (외울 필요 없음)
@res = db.users.insert(@record);

// 확인이 필요할 때만 출력

if (@res) print("성공");



```  sample/list.pq
db.connect();

// 방금 넣은 녀석들 역순으로 10개만 리스트로 가져오기
@data = db.users.sort("idx desc").limit(1, 10);

print(@data);


---

## 🚢 로드맵 (Development Roadmap)

- [x] **v0.7:** 코어 시스템 안착 및 StrFlow 설계
- [ ] **v0.8:** 세션 다이렉트 및 로그인 미들웨어 강화
- [ ] **v0.9:** 캐시 시스템(Lazy Cache) 및 API 다이렉트 모드
- [ ] **v1.0:** 정식 릴리즈 및 템플릿 패키지화

---

## 🤖 Collaborators
*   **Human Architect:** [ozones](https://github.com) (철학 및 설계)
*   **AI Partners:** Gemini & ChatGPT (로직 정교화 및 코어 빌드)

---
© 2026 PQ Engine Project. 누구나 자유롭게 발전시킬 수 있습니다.
