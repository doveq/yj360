@extends('Index.master')
@section('title')注册账号@stop

@section('content')
<div class="container wrap regbox">

    <form class="form-signin" role="form" action="doRegister" method="post">
      {{Form::token()}}
      <h2 class="form-signin-heading">注册账号</h2>
      @foreach($errors->all() as $message)
      <p>{{ $message }}</p>
      @endforeach
      <table class="regtable">
          <tr>
            <td class="lable"><span class="must">*</span>手机号</td>
            <td><input type="text"  class="text" name="tel" value="" placeholder="手机号" ></td>
          </tr>

          <tr>
            <td class="lable">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td class="lable">验证码</td>
            <td><input type="text" class="text" name="verify" value="" placeholder="验证码" ></td>
          </tr>

          <tr>
            <td class="lable"><span class="must">*</span>密  码</td>
            <td><input type="password" class="text" name="password" value="" placeholder="密码" ></td>
          </tr>

          <tr>
            <td class="lable"><span class="must">*</span>重复密码</td>
            <td><input type="password" class="text" name="password_confirmation" value="" placeholder="密码" ></td>
          </tr>

          <tr>
            <td class="lable">真实名</td>
            <td><input type="text" class="text" name="tel" value="" placeholder="手机号" ></td>
          </tr>

          <tr>
            <td class="lable">&nbsp;</td>
            <td>
                <input type="checkbox" class="labelinput" name="teacher" id="checkbox-1" /> <label for="checkbox-1">教师资格认证</label>
            </td>
          </tr>

          <tr>
            <td class="lable">教师资格证书</td>
            <td>
                <div class="fileup">
                <input type='text' name='textfield' id='textfield' class='text' />
                <input type='button' class='selbtn' value='' />
                <input type="file" name="fileField" class="file" id="fileField" size="28" onchange="document.getElementById('textfield').value=this.value" />  
                </div>
            </td>
          </tr>

          <tr>
            <td class="lable">&nbsp;</td>
            <td>
              <button type="submit" class="regbnt"></button>
            </td>
          </tr>

      </table>

    </form>

</div> <!-- /container -->
@stop