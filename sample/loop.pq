trace.on()

@limit = 5

for @i in range(1, 10)
    if @i <= @limit
        msg.print("Number: " + @i)
    end
end