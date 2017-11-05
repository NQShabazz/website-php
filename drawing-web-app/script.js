"use strict";
window.onload = init;

// GLOBALS
// We store the mainCanvas's 2D context and the colorCanvas's 2D context as well as an array of the other canvases's contexts
var _backgroundContext, _currentLayerIndex, _layerArray;
var _imageTitle = "Untitled"; //the title of the image
var _userAction = ""; // what the user is currently doing
var _controlDown = false;

// CONSTANTS


// FUNCTIONS
function init(){
    // initialize some globals
  _backgroundContext = document.querySelector('#backgroundCanvas').getContext('2d');
  _currentLayerIndex = 0;
  _layerArray = new Array();

  // now do general setup
  setupInputs();

  document.body.onmouseup = function(){_userAction = ""; _tool.end(true);} // reset user action once the mouse is released

  setupColorCanvases();

  document.querySelector("#newLayerButton").onmousedown = addLayer; // addLayer functionality

  document.querySelector("#undoButton").onmouseup = function(){_layerArray[_currentLayerIndex].subtractAction();};
  document.querySelector("#redoButton").onmouseup = function(){_layerArray[_currentLayerIndex].restoreAction();}; // addLayer functionality

  document.body.onkeypress = function(e){
    if(e.ctrlKey){
      if((e.shiftKey && e.keyCode === 26) || e.keyCode === 25)
        _layerArray[_currentLayerIndex].restoreAction();
      else if(e.keyCode === 26)
        _layerArray[_currentLayerIndex].subtractAction();
    }
  }
  
  addLayer();
  setCurrentLayer(0);

  changeTool(0);

  // and finally we run the drawing loop:
  draw(1000/60);
}

function changeTool(num){
  let children = document.getElementById("toolSet").children;
  var i = 3;

  while(i--)
    children[i].classList.remove("chosen-tool");

  children[num].classList.add("chosen-tool");

  _tool.toolMode = num;
}

// Function Name: setupInputs()
// Sets up the user to input interactions
// Author: Nazaire Shabazz
// Last update: 02/08/2017
function setupInputs(){
    document.querySelector('#clearButton').onmouseup = clearPrompt;
  
    document.querySelector('#saveButton').addEventListener("click", function(){exportImage(this)});
    
    document.querySelector('#imageTitle').onchange = function(){_imageTitle = this.value;};
    
    document.querySelector('#thicknessRange').oninput = function(){
        _tool.thickness = this.value;
        document.querySelector('#thicknessDisplay').innerText = this.value;
    };
    
    document.querySelector('#fillTransparencyRange').oninput = function(){
        _tool.fillTransparency = this.value;
        document.querySelector('#fillTransparencyDisplay').innerText = (this.value * 100)|0;
    };
    
    document.querySelector('#strokeTransparencyRange').oninput = function(){
        _tool.strokeTransparency = this.value;
        document.querySelector('#strokeTransparencyDisplay').innerText = (this.value * 100)|0;
    };
}

// Function Name: setupColorCanvases()
// Sets up the user to input interactions
// Author: Nazaire Shabazz
// Last update: 02/08/2017
function setupColorCanvases(){
    var gridSize = 5;
    
    for(var i = 0; i < 2; i++){
        var ctx = (i == 0 ? document.querySelector('#fillCanvas') : document.querySelector('#strokeCanvas')).getContext('2d');
        var boxWidth = ctx.canvas.clientWidth / gridSize;
        var boxHeight = ctx.canvas.clientHeight / gridSize;
        
        for(var j = 0; j < gridSize; j++)
            for(var k = 0; k < gridSize; k++){
                ctx.fillStyle = 'hsl(' + ((j * (255/gridSize))|0) + ', 100%, ' + (100 - k * (100/gridSize)) + '%)';
                ctx.fillRect(j*boxWidth, k*boxHeight, boxWidth, boxHeight);
            }
    }
    
    document.querySelector('#fillCanvas').onmousedown = function(e){_userAction = "drawing";}
    document.querySelector('#fillCanvas').onmousemove = function(e){
        if(_userAction == "drawing"){
            var mX = (e.pageX - this.getBoundingClientRect().left) / this.clientWidth;
            var mY = (e.pageY - this.getBoundingClientRect().top) / this.clientHeight;

            _tool.fillColor = 'hsl(' + ((mX * 255)|0) + ', 100%, ' + (100 - (mY * 100)|0) + '%)';
            
            var contrast = 'hsl(' + ((mX * 255)|0) + ', 100%, ' + ((mY * 100)|0) + '%)';

            document.querySelector('#fillSpan').style.backgroundColor = _tool.fillColor;
            document.querySelector('#fillSpan').style.color = contrast;
        }
    }
    
    document.querySelector('#strokeCanvas').onmousedown = function(e){_userAction = "drawing";}
    document.querySelector('#strokeCanvas').onmousemove = function(e){
        if(_userAction == "drawing"){
            var mX = (e.pageX - this.getBoundingClientRect().left) / this.clientWidth;
            var mY = (e.pageY - this.getBoundingClientRect().top) / this.clientHeight;

            _tool.strokeColor = 'hsl(' + ((mX * 255)|0) + ', 100%, ' + (100 - (mY * 100)|0) + '%)';
            
            var contrast = 'hsl(' + ((mX * 255)|0) + ', 100%, ' + ((mY * 100)|0) + '%)';

            document.querySelector('#strokeSpan').style.backgroundColor = _tool.strokeColor;
            document.querySelector('#strokeSpan').style.color = contrast;
        }
    }
}

function addLayer(){
    var newButton = document.getElementById('templateLayerElement').cloneNode(true);
    
    newButton.id = "layerElement" + _layerArray.length;
    newButton.value = _layerArray.length;
    newButton.querySelector(".textBox").value = "Layer " + _layerArray.length;
    newButton.onmousedown = function(){setCurrentLayer(this.value);};
    
    document.querySelector("#layerList").appendChild(newButton);
    
    var newCanvas = document.getElementById('templateCanvas').cloneNode(true);
    
    newCanvas.id = "layer" + _layerArray.length;
    newCanvas.onmousemove = getMouse;
    
    document.querySelector("#canvasContainer").appendChild(newCanvas);
    
    var newLayer = new Layer(_layerArray.length);
    _layerArray.push(newLayer);
    
    setCurrentLayer(_layerArray.length - 1);
}

function removeLayer(index){
  if(_currentLayerIndex === index)
      setCurrentLayer(0);
  
  var layerButton = document.querySelector("#layerElement" + index);
  layerButton.parentNode.removeChild(layerButton);

  var layerCanvas = document.querySelector("#layer" + index);
  layerCanvas.parentNode.removeChild(layerCanvas);

  _layerArray.splice(index, 1);

  if(index == 0)
    addLayer();
}

function setCurrentLayer(index){
    if(document.querySelector(".currentLayerElement") !== null)
        document.querySelector(".currentLayerElement").classList.remove("currentLayerElement");
    if(document.querySelector("#layerElement" + index) !== null){
        document.querySelector("#layerElement" + index).classList.add("currentLayerElement");

        _layerArray[_currentLayerIndex].currentLayer = false;
        _layerArray[index].currentLayer = true;
        _currentLayerIndex = index;
    }else{
        setCurrentLayer(0);
    }
}

function toggleVisible(index){
    _layerArray[index].visible = !_layerArray[index].visible;
}

function setUserToDraw(){
    _userAction = "action";
    _tool.start();
}

function draw(timestamp) {
    setTimeout(function() {
        requestAnimationFrame(draw);
        
        for(var i = 0; i < _layerArray.length; i++){
            _layerArray[i].draw();
        }
    }, 1000/60);
}

// EVENT CALLBACK FUNCTIONS

function doClear(){
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
    drawGrid(ctx,'lightgray', 10, 10);
}

function downloadCanvas(link, canvasId, filename) {
    link.href = document.getElementById(canvasId).toDataURL();
    link.download = filename;
}

// Function Name: clearPrompt()
// Asks user to confirm they want to clear the screen
// Basically it will removeLayer() every layer but the first
// Author: Nazaire Shabazz
// Last update: 02/08/2017
function clearPrompt(){
    _tool.canDraw = false;
  
    if(window.confirm("Are u sure u want to clear the canvas?")){
      for(var i = 0; i < _layerArray.length; i++){
          removeLayer(i);
      }
    }
    
    _tool.canDraw = true;        
}
// Function Name: exportPrompt()
// Asks user to confirm they want to save their image
// Basically it will create a new layer, drawImage() each layer onto the new one, then export the new one
// Author: Nazaire Shabazz
// Last update: 02/08/2017
function exportImage(elem){
    _tool.canDraw = false;
    
    addLayer();
    
    for(var i = 0; i < _layerArray.length - 1; i++)
        _layerArray[_currentLayerIndex].ctx.drawImage(_layerArray[i].ctx.canvas, 0, 0);
        
    elem.href=_layerArray[_currentLayerIndex].ctx.canvas.toDataURL();
    elem.download = _imageTitle;
    
    removeLayer(_currentLayerIndex);
    
    _tool.canDraw = true;        
}

// UTILITY FUNCTIONS
/*
These utility functions do not depend on any global variables being in existence, 
and produce no "side effects" such as changing ctx state variables.
They are "pure functions" - see: http://en.wikipedia.org/wiki/Pure_function
*/

// Function Name: getMouse()
// returns mouse position in local coordinate system of element
// Author: Tony Jefferson
// Edited by Nazaire Shabazz
// Last update: 3/1/2014
function getMouse(e){
    if(e !== undefined){
        var mouse = {}
        //old bad code
        //mouse.x = e.pageX - e.target.offsetLeft;
        // mouse.y = e.pageY - e.target.offsetTop;
        //return mouse;

        mouse.x = (e.pageX - this.getBoundingClientRect().left);
        mouse.y = (e.pageY - this.getBoundingClientRect().top);

        _tool.mousePosition = mouse;
    }
}