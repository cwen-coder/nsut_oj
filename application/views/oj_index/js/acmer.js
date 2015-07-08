var Table = document.getElementById("Table");
// write_table(4,3);
//填表格，m表示第几列，n表示m列的后n个cells
function getColor(colorKey){
	switch(colorKey){
		// case 14:return "rgb(164,47,40)";
		// case 13:return "rgb(167,102,37)";
		case 9:return "rgb(182,186,18)";
		case 8:return "rgb(111,187,17)";
		case 7:return "rgb(28,185,19)";
		case 6:return "rgb(23,181,102)";
		case 5:return "rgb(21,167,183)";
		case 4:return "rgb(23,96,181)";
		case 3:return "rgb(22,31,182)";
		case 2:return "rgb(90,23,181)";
		case 1:return "rgb(147,21,183)";
		case 0:return "rgb(182,22,130)";
		/*case 4:return "rgb(203,1,21)";
		case 3:return "rgb(152,1,16)";
		case 2:return "rgb(131,1,14)";
		case 1:return "rgb(92,3,5)";
		case 0:return "rgb(30,30,30)";*/

	}

}
function write_table(pId,m,n){
	var pTableId = document.getElementById(pId);
	//console.log(pId);
	//alert('jjjj');
	var rowLen = pTableId.rows.length;
	for(var j = rowLen-1;j>(rowLen-1-n);j--){
		pTableId.rows[j].cells[m].style.backgroundColor=getColor(j);
	}
}