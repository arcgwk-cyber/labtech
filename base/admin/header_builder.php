<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Advanced Header Builder</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>

<style>
body { background:#eef2f7; }

#canvas {
    width:100%;
    height:280px;
    background:#fff;
    border:2px dashed #cbd5e1;
    position:relative;
    overflow:hidden;
}

.element {
    position:absolute;
    cursor:move;
    padding:4px;
    min-width:40px;
    min-height:20px;
}

.selected {
    outline:2px solid #2563eb;
}

.box-border {
    border:1px solid #000;
}

.table-element table {
    width:100%;
    border-collapse:collapse;
}

.table-element td {
    border:1px solid #000;
    padding:3px;
}
</style>
</head>
<body>

<div class="container-fluid mt-3">
<div class="row">

<!-- LEFT PANEL -->
<div class="col-md-3 bg-white p-3 shadow-sm">

<h5>Add Elements</h5>

<button class="btn btn-primary btn-sm w-100 mb-2" onclick="addText()">Text</button>
<button class="btn btn-secondary btn-sm w-100 mb-2" onclick="addDynamic()">Dynamic Field</button>
<button class="btn btn-success btn-sm w-100 mb-2" onclick="addQR()">QR</button>
<button class="btn btn-warning btn-sm w-100 mb-2" onclick="addPhoto()">Photo</button>
<button class="btn btn-dark btn-sm w-100 mb-2" onclick="addBox()">Box</button>
<button class="btn btn-info btn-sm w-100 mb-3" onclick="addTable()">Table</button>

<hr>

<h6>Element Controls</h6>

<input type="number" id="widthInput" class="form-control form-control-sm mb-2" placeholder="Width (px)">
<input type="number" id="heightInput" class="form-control form-control-sm mb-2" placeholder="Height (px)">
<button class="btn btn-outline-primary btn-sm w-100 mb-2" onclick="applySize()">Apply Size</button>
<button class="btn btn-outline-secondary btn-sm w-100 mb-2" onclick="autoSize()">Auto Size</button>

<button class="btn btn-outline-dark btn-sm w-100 mb-2" onclick="toggleBold()">Bold</button>
<button class="btn btn-outline-dark btn-sm w-100 mb-2" onclick="toggleBorder()">Toggle Border</button>

<button class="btn btn-danger btn-sm w-100 mb-2" onclick="deleteElement()">Delete Selected</button>
<button class="btn btn-warning btn-sm w-100 mb-2" onclick="duplicateElement()">Duplicate</button>

<hr>

<button class="btn btn-success w-100" onclick="saveTemplate()">Save Template</button>

</div>

<!-- CANVAS -->
<div class="col-md-9">
<div id="canvas"></div>
</div>

</div>
</div>

<script>

let selected = null;

function makeInteractive(el){
    interact(el)
    .draggable({
        listeners:{
            move(event){
                let x=(parseFloat(el.dataset.x)||0)+event.dx;
                let y=(parseFloat(el.dataset.y)||0)+event.dy;

                el.style.transform=`translate(${x}px, ${y}px)`;
                el.dataset.x=x;
                el.dataset.y=y;
            }
        }
    })
    .resizable({
        edges:{left:true,right:true,top:true,bottom:true},
        listeners:{
            move(event){
                el.style.width=event.rect.width+"px";
                el.style.height=event.rect.height+"px";
            }
        }
    });
}

function selectElement(el){
    document.querySelectorAll('.element').forEach(e=>e.classList.remove('selected'));
    el.classList.add('selected');
    selected=el;
}

function createElement(type,content,className=''){
    let el=document.createElement("div");
    el.className="element "+className;
    el.dataset.type=type;
    el.innerHTML=content;
    el.onclick=()=>selectElement(el);

    document.getElementById("canvas").appendChild(el);
    makeInteractive(el);
}

function addText(){ createElement("text","Sample Text"); }
function addDynamic(){ createElement("dynamic","{patient_name}"); }
function addQR(){ createElement("qr","QR"); }
function addPhoto(){ createElement("photo","Photo"); }
function addBox(){ createElement("box",""); }

function addTable(){
    let tableHTML=`
    <table>
        <tr><td>Cell 1</td><td>Cell 2</td></tr>
        <tr><td>Cell 3</td><td>Cell 4</td></tr>
    </table>`;
    createElement("table",tableHTML,"table-element");
}

function applySize(){
    if(!selected) return;
    let w=document.getElementById("widthInput").value;
    let h=document.getElementById("heightInput").value;
    if(w) selected.style.width=w+"px";
    if(h) selected.style.height=h+"px";
}

function autoSize(){
    if(!selected) return;
    selected.style.width="auto";
    selected.style.height="auto";
}

function toggleBold(){
    if(!selected) return;
    selected.style.fontWeight=
        selected.style.fontWeight=="bold"?"normal":"bold";
}

function toggleBorder(){
    if(!selected) return;
    selected.classList.toggle("box-border");
}

function deleteElement(){
    if(!selected) return;
    selected.remove();
    selected=null;
}

function duplicateElement(){
    if(!selected) return;
    let clone=selected.cloneNode(true);
    document.getElementById("canvas").appendChild(clone);
    makeInteractive(clone);
}

function saveTemplate(){

    let data=[];
    document.querySelectorAll(".element").forEach(el=>{
        data.push({
            type:el.dataset.type,
            content:el.innerHTML,
            x:el.dataset.x||0,
            y:el.dataset.y||0,
            width:el.style.width||'',
            height:el.style.height||'',
            fontWeight:el.style.fontWeight||'',
            border:el.classList.contains("box-border")
        });
    });

    fetch("save_header_template.php",{
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify({layout:data})
    })
    .then(res=>res.text())
    .then(()=>alert("Template Saved"));
}

</script>
</body>
</html>
