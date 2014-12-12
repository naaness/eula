<div class="form-box" id="login-box">
    <div class="header">Sign In</div>
    <form action="" method="post">
    	<input type="hidden" name="login" value="1" id="log"/>
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="usuario" class="form-control" placeholder="User ID"/>
            </div>
            <div class="form-group">
                <input type="password" name="pass" class="form-control" placeholder="Password"/>
            </div> 
            {if isset($_error)}
                <p class="text-red">{$_error}</p>
            {/if}
        </div>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-olive btn-block">Sign me in</button> 
        </div>

    </form>

    <div class="margin text-center">
        <span>Sign in using social networks</span>
        <br/>
        <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
        <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
        <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

    </div>
</div>