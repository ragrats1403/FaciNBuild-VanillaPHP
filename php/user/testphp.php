<html>
    
    <body>

    <div class="alert alert-info">
    Boostrap Multi-Page Modal - Each <br><code>&lt;div class=&quot;modal-split&quot;&gt;&lt;/div&gt;</code> <br>Declaration is a page. 
  </div>

<!-- Button trigger modal -->
<div class="button">
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      
      </div>
      
      <div class="modal-body">
	  
        <div class="modal-split">
		1
		</div>
		
		<div class="modal-split">
		2
		</div>
		
		<div class="modal-split">
		3
		</div>	

      </div>

      <div class="modal-footer">
 <!--Nothing Goes Here but is needed! -->
      </div>
    </div>
  </div>
</div>

  <div class="alert alert-info">
   EX: (These divs go in the modal-body) <br><code>&lt;div class=&quot;modal-split&quot;&gt; Page 1 content goes here &lt;/div&gt;<br>&lt;div class=&quot;modal-split&quot;&gt; Page 2 content goes here &lt;/div&gt;<br>&lt;div class=&quot;modal-split&quot;&gt; and so on  &lt;/div&gt;</code>
  </div>

    </body>
</html>