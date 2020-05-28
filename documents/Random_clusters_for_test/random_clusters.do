
use "C:\PeadsDept\NNS2\Listing\enumblock1.dta",clear  
	
	levelsof dcode, local(dc)
	gen sel = .
	foreach val of local dc {
		set seed 1234
		sort dcode cluster 
		cap drop tmp 
		randomtag if dcode==`val', count(1) gen(tmp)
		replace sel = 1 if tmp==1 & dcode==`val'
		drop tmp
	}
	
	keep if sel == 1

	keep ebcode geoarea cluster pcode block ur provcode
	sort cluster
	ren cluster clust_orig
	gen id = _n
	order id, first
	gen cluster = real("8"+string(123+_n,"%03.0f"))
	order id ebcode block cluster geoarea pcode ur 
	
	duplicates report cluster
	assert `r(N)' == `r(unique_value)'
	
	export excel using "C:\Temp\test_clusters.xlsx", firstrow(variables) nolabel replace
