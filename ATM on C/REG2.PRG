CLEAR
CLOSE DATABASES
SET TALK OFF

num = 0
temlname= space(10)
temfname= space(10)
temmname= space(2)
f=0
bdate= {00/00/00}
tdate= {00/00/00}
actype= space(2)
bal=0
initbal= space(6)

@1,15 say " **DEPOSITOR CHECK** "
@2,5 say "Enter Depositor's#: " get num PICTURE "###"



@6,5 say"LASTNAME"
@6,16 say"FIRST NAME"
@6,30 say"MI"
@7,5 get temlname
@7,16 get temfname
@7,30 get temmname	
READ

use deps.dbf
goto bottom
IF EOF(num)		
		@7,5 say "NO RECORD!"
ENDIF
f=0		 
point=0
point = depo_id

	IF(num<=point)
	go num

	
		IF last=UPPER(temlname)
			f=f+1
		ELSE
			f=f-1
		ENDIF
		IF first=UPPER(temfname)
			f=f+1
		ELSE
			f=f-1
		ENDIF
		IF mi=UPPER(temmname)
			f=f+1
		ELSE
			f=f-1		
		ENDIF
	ENDIF

	IF(f<3)
		@ 10,5 say "Name not found!"
		do reg2
		
	ENDIF

		
CLEAR
WAIT WINDOW 'DEPOSITOR CONFIRMED' NOWAIT
tpin = space(4)

@1,1 say "**** ACCOUNTS ****"
@2,1 say num PICTURE "-###-"
@5,5 say "BIRTHDAY(MM/DD/YY): "
@4,5 get bdate
@7,5 say "[S]Savings"
@8,5 say "[C]Cheque"
@6,5 say "Account type: " get actype
@9,1 say "PIN#: "get tpin
@10,1 say "INITIAL BALANCE:"
	DO WHILE( bal<500)
		@10,18 get initbal
		READ
			bal=VAL(initbal)
			IF (bal <500 )
				@7,25 say "INVALID AMOUNT"
			ENDIF	
	ENDDO



READ
USE accts.dbf
go bottom
last = acc_num+99
last = last+1
append blank
	replace acc_num with last
	replace depo_id with num
	replace birthdate with bdate
	replace opendate with date()
	replace type with actype
	replace balance with bal
	replace pin with tpin
	
y = YEAR(bdate)
m = MONTH(bdate)
d = DAY(bdate)
datetoday = date()
oy = (YEAR(datetoday) % 1000)
om = MONTH(datetoday)

CLEAR
temtype=0

@8,1 say "Your account#: "
		IF (UPPER(actype)='S')	
			@9,1 say "02"
			temtype=2
		ENDIF
		IF (UPPER(actype)='C')
			@9,1 say "03"
			temtype=3
		ENDIF

@9,3 say last PICTURE "###"
@9,7 say "-"
@9,8 say y PICTURE "####"
@9,12 say m PICTURE "##"
@9,14 say d PICTURE "##"
@9,16 say "-"
@9,17 say om PICTURE "##"
@9,19 say oy PICTURE "##"




