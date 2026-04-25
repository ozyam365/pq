trace.on()

@data = http.get("https://api.coinbase.com/v2/prices/spot?currency=USD").json()

msg.print("BTC: " + @data["data"]["amount"])