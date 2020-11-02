# Rsi Default

```
//@version=4
strategy("RSI Strategy", overlay=true)
length = input( 14 )
overSold = input( 30 )
overBought = input( 70 )
price = close
vrsi = rsi(price, length)
co = crossover(vrsi, overSold)
cu = crossunder(vrsi, overBought)
if (not na(vrsi))
	if (co)
		strategy.entry("RsiLE", strategy.long, comment="RsiLE")
	if (cu)
		strategy.entry("RsiSE", strategy.short, comment="RsiSE")
//plot(strategy.equity, title="equity", color=color.red, linewidth=2, style=plot.style_areabr)
```
