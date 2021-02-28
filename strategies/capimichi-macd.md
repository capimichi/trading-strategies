// This source code is subject to the terms of the Mozilla Public License 2.0 at https://mozilla.org/MPL/2.0/
// © capimichi

//@version=4
strategy("MACD Strategy Capimichi", overlay=true)
fastLength = input(12)
slowlength = input(26)
MACDLength = input(9)
emaSize = input(200)
leverage = input(100)
freeSize = input(10)

emaCheck = ema(close, emaSize)

stopLossPercentage = input(2.0, title='Stop Loss %') / (100 * leverage)
takeProfitPercentage = input(4.0, title='Take Profit %') / (100 * leverage)


MACD = ema(close, fastLength) - ema(close, slowlength)
aMACD = ema(MACD, MACDLength)
delta = MACD - aMACD


if (crossover(delta, 0) and (close > emaCheck))
	strategy.entry("MacdLE", strategy.long, comment="MacdLE")
if (crossunder(delta, 0) and (close < emaCheck))
	strategy.entry("MacdSE", strategy.short, comment="MacdSE")
	
buyStopLossLevel = strategy.position_avg_price * (1 - stopLossPercentage)
buyTakeProfitLevel = strategy.position_avg_price * (1 + takeProfitPercentage)
sellStopLossLevel = strategy.position_avg_price * (1 + stopLossPercentage)
sellTakeProfitLevel = strategy.position_avg_price * (1 - takeProfitPercentage)

if(strategy.position_size > 0)
    if(close > buyTakeProfitLevel)
        strategy.close("MacdLE")
    if(close < buyStopLossLevel)
        strategy.close("MacdLE")

if(strategy.position_size < 0)
    if(close > sellStopLossLevel)
        strategy.close("MacdSE")
    if(close < sellTakeProfitLevel)
        strategy.close("MacdSE")

plot(emaCheck, color = color.green)
