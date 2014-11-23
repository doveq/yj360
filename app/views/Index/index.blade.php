@extends('Index.master')
@section('title')首页 @stop

@section('content')
    <div class="container wrap">
    	<a class="index-block" href="/"><img src="/assets/img/index-2-1.png" /></a>

        <!--
    	<a class="index-block" href="#"><img src="/assets/img/index-2.jpg" /></a>
    	<a class="index-block" href="#"><img src="/assets/img/index-3.jpg" /></a>
    	<a class="index-block" href="#"><img src="/assets/img/index-4.jpg" /></a>
    	<a class="index-block" href="#"><img src="/assets/img/index-5.jpg" /></a>
    	<div id="index-block-ksrk">

    	</div>
        -->

        <div class="index-block" id="index-login">
            <form role="form" action="doLogin" method="post">
            <!--
            <h1>音基360登录</h1>
            -->
            <div class="row" style="padding:0;"><img src="/assets/img/index-a4.png" /></div>
            <div class="row"><input id="login-input-name" type="text" class="text" name="name" value="" placeholder="手机号" ></div>
            <div class="row"><input id="login-input-passwd" type="password"  class="text" name="password" value="" class="form-control" placeholder="密码"> </div>
            <div class="row">
                <input type="checkbox" name="" id="checkbox-1" class="labelinput" /> <label for="checkbox-1">记住密码</label>
                <a href="/forgot" class="forget">忘记密码？</a>
                <div class="clear"></div>
            </div>
            <div class="row">
                <button type="submit" class="loginbntn">登 录</button>
            </div>

            <div class="row-sp"></div>

            <div class="row linetxt">
                还没有音基360账号？<a href="/register">马上注册</a>
            </div>

            </form>
        </div>

    	<div class="clear" style="height:25px;"></div>
        <a class="index-block" href="/column/static"><img src="/assets/img/index-a3.png" /></a>
        <a class="index-block" style="margin-left:25px;" style="" href="/column/static"><img src="/assets/img/index-a2.png" /></a>
        <a class="index-block" style="margin-left:25px;" href="/column/static"><img src="/assets/img/index-a1.png" /></a>

        <!--
    	<div class="index-list">
    		<div class="index-list-head">
    			<img src="/assets/img/index-list-1.jpg" />
    		</div>

    		<ul id="index-list-1">
    			<li><a href="">教材强化学习</a></li>
    			<li><a href="">教材强化学习</a></li>
    			<li><a href="">教材强化学习</a></li>
    			<li class="index-list-more"><a href="/indexColumn">更多 >></a></li>
    		</ul>

    		<div class="index-list-footer">
    			<img src="/assets/img/index-list-2.jpg" />
    		</div>
    	</div>

    	<div class="index-list">
    		<div class="index-list-head">
    			<img src="/assets/img/index-list-3.jpg" />
    		</div>

    		<ul id="index-list-2">
    			<li><a href="">教材强化学习</a></li>
    			<li><a href="">教材强化学习</a></li>
    			<li><a href="">教材强化学习</a></li>
    			<li class="index-list-more"><a href="">更多 >></a></li>
    		</ul>

    		<div class="index-list-footer">
    			<img src="/assets/img/index-list-4.jpg" />
    		</div>
    	</div>

    	<div class="index-list">
    		<div class="index-list-head">
    			<img src="/assets/img/index-list-5.jpg" />
    		</div>

    		<ul id="index-list-3">
    			<li><a href="">教材强化学习</a></li>
    			<li><a href="">教材强化学习</a></li>
    			<li><a href="">教材强化学习</a></li>
    			<li class="index-list-more"><a href="">更多 >></a></li>
    		</ul>

    		<div class="index-list-footer">
    			<img src="/assets/img/index-list-6.jpg" />
    		</div>
    	</div>

    	<div class="index-list">
    		<div class="index-list-head">
    			<img src="/assets/img/index-list-7.jpg" />
    		</div>

    		<ul id="index-list-4">
    			<li><a href="">教材强化学习</a></li>
    			<li><a href="">教材强化学习</a></li>
    			<li><a href="">教材强化学习</a></li>
    			<li class="index-list-more"><a href="">更多 >></a></li>
    		</ul>

    		<div class="index-list-footer">
    			<img src="/assets/img/index-list-8.jpg" />
    		</div>
    	</div>
        -->
      	<div class="clear"></div>
    </div> <!-- /container -->
@stop