# Macd Default

```
//@version=4
strategy("MACD Strategy", overlay=true)
fastLength = input(12)
slowlength = input(26)
MACDLength = input(9)
MACD = ema(close, fastLength) - ema(close, slowlength)
aMACD = ema(MACD, MACDLength)
delta = MACD - aMACD
if (crossover(delta, 0))
	strategy.entry("MacdLE", strategy.long, comment="MacdLE")
if (crossunder(delta, 0))
	strategy.entry("MacdSE", strategy.short, comment="MacdSE")
//plot(strategy.equity, title="equity", color=color.red, linewidth=2, style=plot.style_areabr)
```