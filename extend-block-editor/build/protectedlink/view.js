(()=>{"use strict";window.publicMembergate.protectedLink={},function(){let e=[];window.publicMembergate.protectedLink.subscribe=function(t){e.push(t)},window.publicMembergate.protectedLink.updateIntendedLink=function(t){for(let n of e)n(t)}}(),window.addEventListener("DOMContentLoaded",(()=>{document.querySelectorAll(".wp-block-membergate-protectedlink [data-action='open-overlay']").forEach((e=>e.addEventListener("click",(e=>{e.preventDefault();const t=e.target.getAttribute("href");window.publicMembergate.protectedLink.updateIntendedLink(t),document.querySelector("#membergate_overlay_root").dataset.state="active"}))))}))})();