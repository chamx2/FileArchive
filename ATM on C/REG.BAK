CLEAR
CLOSE DATABASES


lname = space(10)
fname = space(10)
mname= space(2)
xaddress = space(20)
contactnum = space(11)
xnat = space(15)

tlast=0

@ 1,6 say "**DEPOSITOR REGISTRATION**"
@ 3,1 say " LASTNAME "
@ 3,13 say " FIRSTNAME "
@ 3,25 say" MI "
@ 2,1 get lname
@ 2,13 get fname
@ 2,25 get mname
@ 4,1 say "address:  "get xaddress
@ 5,1 say "contactno:  "get contactnum
@ 6,1 say "nationality:   "get xnat
read

use deps
go bottom
tlast= depo_id
tlast=tlast+1
append blank

replace depo_id with tlast
replace last with UPPER(lname)
replace first with UPPER(fname)
replace mi with UPPER(mname)
replace address with xaddress
replace national with xnat

use depid
append blank

replace depo_id with tlast
replace contact with contactnum

g=0

@7,5 say "Your depositor#: "
@7,23 say tlast PICTURE "-###-" FUNCTION "L"



	



