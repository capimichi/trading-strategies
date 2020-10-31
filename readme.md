# Trading Strategies

## Take Profit / Stop Loss

```
stopLossPercentage = input(2.0, title='Stop Loss %') / 100
takeProfitPercentage = input(4.0, title='Take Profit %') / 100
buyStopLossLevel = strategy.position_avg_price * (1 - stopLossPercentage)
buyTakeProfitLevel = strategy.position_avg_price * (1 + takeProfitPercentage)
sellStopLossLevel = strategy.position_avg_price * (1 + stopLossPercentage)
sellTakeProfitLevel = strategy.position_avg_price * (1 - takeProfitPercentage)
```
