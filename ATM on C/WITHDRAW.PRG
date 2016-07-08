CLEAR
CLOSE DATABASES
SET TALK OFF

use medium.dbf

tid=trans_num
acnum=acc_num
type=checker
td=date
tt=time
pera = balance


@1,15 say " Withdraw "
@5,5 say "Amount: "
money=space(8)
@5,15 get money PICTURE "@9"

read
bals=VAL(money)
DO WHILE( bals >pera )
		WAIT WINDOW 'INSUFFICIENT MONEY'
	@5,15 get money PICTURE "@9"
	read
	bals = VAL(money)
	IF( bals >pera)
		WAIT WINDOW 'INSUFFICIENT MONEY'
	ENDIF
	money = space(6)
ENDDO
remainbal = pera - bals

@7,5 say "Your balance: "
@7,19 say remainbal COLOR G+

transid=0

use t_logs.dbf
go bottom

append blank
transid = transid + 1

replace transno with transid
replace transamnt with bals
replace balance with remainbal
replace date with date()
replace time with time()