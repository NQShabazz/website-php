class Layer{
    constructor(index){
        this.index = index;
        this.visible = true;
        this.history = new Array(); //[[x][y][x1][y1][drawType][strokeWidth][fillStyle][strokeStyle][fillAlpha][strokeAlpha][startOfAction?][endOfAction?]]
        this.future = new Array();
        this.ctx = document.querySelector("#layer" + index).getContext('2d');
        this.currentLayer = false;
    }    
    
    draw(){
        this.ctx.clearRect(0, 0, this.ctx.canvas.width, this.ctx.canvas.height);
        
        if(this.visible){
            for(var i = 0; i < this.history.length; i++){
                this.ctx.lineWidth = this.history[i][5];
                this.ctx.fillStyle = this.history[i][6];
                this.ctx.strokeStyle = this.history[i][7];
                this.ctx.globalAlpha = this.history[i][8];
                this.ctx.lineJoin = 'round';
                this.ctx.lineCap = 'round';
                
                switch(this.history[i][4]){
                    case DrawType.pencil:
                    case DrawType.line:
                        this.ctx.globalAlpha = this.history[i][9];
                        
                        if(this.history[i][10]){
                            this.ctx.beginPath();
                            this.ctx.moveTo(this.history[i][0], this.history[i][1]);
                        }else
                            this.ctx.moveTo(this.history[i-1][0], this.history[i-1][1]);
                        
                        this.ctx.lineTo(this.history[i][2], this.history[i][3]);
                        
                        if(this.history[i][11] || i == this.history.length - 1){
                            this.ctx.stroke();
                        }
                        break;
                    case DrawType.rectangle:
                        this.ctx.beginPath();
                        this.ctx.rect(this.history[i][0], this.history[i][1], this.history[i][2] - this.history[i][0], this.history[i][3] - this.history[i][1]);
                        this.ctx.fill();
                        this.ctx.globalAlpha = this.history[i][9];
                        this.ctx.stroke();
                        break;
                }
            }
            
            if(this.currentLayer)
                _tool.draw(this.ctx);
        }
    }
    
    addAction(action){
        this.history.push(action);
        this.future = [];
    }
    subtractAction(){
        if(this.history.length > 0){
            var i = this.history.length - 1;
            while(!this.history[i][10]){
                this.future.push(this.history.pop());
                i--;
            }
            this.future.push(this.history.pop());
        }
    }
    restoreAction(){
        if(this.future.length > 0){
            var i = this.future.length - 1;
            while(!this.future[i][11]){
                this.history.push(this.future.pop());
                i--;
            }
            this.history.push(this.future.pop());
        }
    }
}