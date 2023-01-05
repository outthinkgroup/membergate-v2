export function selectValue(e:Event){
	return [...e.target.childNodes].find(el=>el.selected).value
}
	
