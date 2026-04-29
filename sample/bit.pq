@base = "https://api.coinbase" . ".com";
@path = "/v2/prices/BTC-USD/spot";
@target = @base . @path;

@res = http.url(@target).send();

print("--- 데이터 확인 ---");
print(@res); 

if(@res.data) {
    print("현재 비트코인 시세: $" . @res.data.amount);
}