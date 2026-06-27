;((window,document)=>{ // EmployeeContentWidget
function downloadToFile(e,a,o){var t=document.createElement("a"),e=new Blob([e],{type:o});t.href=URL.createObjectURL(e),t.download=a,t.click(),URL.revokeObjectURL(t.href)}function previewFile(e){let a=new FileReader;e=e.target.files[0];a.readAsDataURL(e),a.onloadend=()=>previewEl.src=a.result}function makeVCard(e,a,o,t,d,n,r){downloadToFile(`BEGIN:VCARD
VERSION:3.0
N:${e}
FN:${a}
ORG:${o}
TITLE:${t}
`+`TEL;TYPE=WORK,VOICE:${d}
ADR;TYPE=WORK,PREF:;;${n}
EMAIL:${r}
REV:${(new Date).toISOString()}
END:VCARD`,"vcard.vcf","text/vcard")}window.downloadVCard=(e,a,o,t,d)=>{makeVCard("",e,a,o,t,"",d)};
})(_window,_document);
