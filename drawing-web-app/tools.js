var DrawType = {
    pencil: 0,
    line: 1,
    rectangle: 2
}
var _tool = {
    toolMode: DrawType.rectangle,
    isDrawing: false,
    justStarted: false,
    startPosition: {x: 0, y: 0},
    mousePosition: {x: 0, y: 0},
    thickness: 10,
    fillColor: "hsl(0, 100%, 100%)",
    strokeColor: "hsl(0, 100%, 0%)",
    fillTransparency: 1,
    strokeTransparency: 1,
    canDraw: true,
    start: function(){
        if(this.canDraw && !this.isDrawing){
            this.isDrawing = true;
            this.justStarted = true;
            this.startPosition = this.mousePosition;
        }
    },
    end: function(trulyEnding){
        if(this.isDrawing){
            var endPosition = this.mousePosition;
            var action = [this.startPosition.x, this.startPosition.y, endPosition.x, endPosition.y, this.toolMode, this.thickness, this.fillColor, this.strokeColor, this.fillTransparency, this.strokeTransparency, this.justStarted, trulyEnding];
            
            _layerArray[_currentLayerIndex].addAction(action);
            
            this.isDrawing = false;
            this.justStarted = false;
        }
    },
    draw: function(ctx){
        
        if(this.isDrawing){
            ctx.lineWidth = this.thickness;
            ctx.fillStyle = this.fillColor;
            ctx.strokeStyle = this.strokeColor;
            ctx.globalAlpha = this.fillTransparency;
                
            switch(this.toolMode){
                case DrawType.pencil:
                case DrawType.line:
                    ctx.globalAlpha = this.strokeTransparency;
                    ctx.beginPath();
                    ctx.moveTo(this.startPosition.x, this.startPosition.y);
                    ctx.lineTo(this.mousePosition.x, this.mousePosition.y);

                    ctx.stroke();
                    break;
                case DrawType.rectangle:
                    ctx.beginPath();
                    ctx.rect(this.startPosition.x, this.startPosition.y, this.mousePosition.x - this.startPosition.x, this.mousePosition.y - this.startPosition.y);
                    ctx.fill();
                    ctx.globalAlpha = this.strokeTransparency;
                    ctx.stroke();
                    break;
            }
            
            if(this.toolMode === DrawType.pencil){
                this.end(false);
                this.start();
                this.justStarted = false;
            }
        }
    }
}