# Macd Default

```
//@version=4
strategy("Bollinger Bands Strategy", overlay=true)
source = close
length = input(20, minval=1)
mult = input(2.0, minval=0.001, maxval=50)
basis = sma(source, length)
dev = mult * stdev(source, length)
upper = basis + dev
lower = basis - dev
buyEntry = crossover(source, lower)
sellEntry = crossunder(source, upper)
if (crossover(source, lower))
	strategy.entry("BBandLE", strategy.long, stop=lower, oca_name="BollingerBands", oca_type=strategy.oca.cancel, comment="BBandLE")
else
	strategy.cancel(id="BBandLE")
if (crossunder(source, upper))
	strategy.entry("BBandSE", strategy.short, stop=upper, oca_name="BollingerBands", oca_type=strategy.oca.cancel, comment="BBandSE")
else
	strategy.cancel(id="BBandSE")
//plot(strategy.equity, title="equity", color=color.red, linewidth=2, style=plot.style_areabr)
```