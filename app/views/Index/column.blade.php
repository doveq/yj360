@extends('Index.master')
@section('title')首页 @stop

@section('content')
    <div class="container wrap">
    	<div class="column-cj">
            <h2>配套教材</h2>
            @foreach ($ptjc as $list)
            <a class="column-ab" href="/topic?column={{$list->id}}">{{$list->name}}</a>
            @endforeach
            <div class="clear"></div>
            <div class="column-dbc"></div>
            <h2>专题训练</h2>
            @foreach ($ztxl as $list)
            <a class="column-bk" href="/topic?column={{$list->id}}" style="background-color:{{$color[array_rand($color)]}};">{{$list->name}}</a>
            @endforeach
            <div class="clear"></div>
            <div class="column-dbc"></div>
            <h2>模拟测试</h2>
            <div class="column-dbc"></div>
            <h2>真题测试</h2>
            @foreach ($ztcs as $list)
            <a class="column-ab" href="/topic?column={{$list->id}}">{{$list->name}}</a>
            @endforeach
            <div class="clear"></div>
            <div class="column-dbc"></div>
            <h2>难点解答</h2>
            @foreach ($ndjd as $list)
            <a class="column-nd" href="#">
                <img src="/assets/img/column-test.jpg" width="200" height="150" />
                <div class="column-dinan">
                    <p>{{$list->name}}</p>
                    <p>作者</p>
                </div>
            </a>
            @endforeach
            <a class="column-nd" href="#">
                <img src="/assets/img/column-test.jpg" width="200" height="150" />
            </a>
            <a class="column-nd" href="#">
                <img src="/assets/img/column-test.jpg" width="200" height="150" />
            </a>
        </div>
        <br><br>

        <div class="column-zj">
            <h2>配套教材</h2>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <div class="clear"></div>
            <div class="column-dbc"></div>
            <h2>专题训练</h2>
            <a class="column-bk" href="#" style="background-color:#2fc8d0;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#efc825;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#5fc1e8;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#f28695;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#f49543;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#abd663;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#b18ac1;">初级乐理</a>

            <a class="column-bk" href="#" style="background-color:#2fc8d0;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#efc825;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#5fc1e8;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#f28695;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#f49543;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#abd663;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#b18ac1;">初级乐理</a>
            <div class="clear"></div>
            <div class="column-dbc"></div>
            <h2>模拟测试</h2>
            <div class="column-dbc"></div>
            <h2>真题测试</h2>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <div class="clear"></div>
            <div class="column-dbc"></div>
            <h2>难点解答</h2>
            <a class="column-nd" href="#">
                <img src="/assets/img/column-test.jpg" width="200" height="150" />
                <div class="column-dinan">
                    <p>标题标题标题标题</p>
                    <p>作者</p>
                </div>
            </a>
            <a class="column-nd" href="#">
                <img src="/assets/img/column-test.jpg" width="200" height="150" />
            </a>
            <a class="column-nd" href="#">
                <img src="/assets/img/column-test.jpg" width="200" height="150" />
            </a>
        </div>
        <br><br>

        <div class="column-gj">
            <h2>配套教材</h2>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <div class="clear"></div>
            <div class="column-dbc"></div>
            <h2>专题训练</h2>
            <a class="column-bk" href="#" style="background-color:#2fc8d0;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#efc825;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#5fc1e8;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#f28695;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#f49543;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#abd663;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#b18ac1;">初级乐理</a>

            <a class="column-bk" href="#" style="background-color:#2fc8d0;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#efc825;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#5fc1e8;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#f28695;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#f49543;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#abd663;">初级乐理</a>
            <a class="column-bk" href="#" style="background-color:#b18ac1;">初级乐理</a>
            <div class="clear"></div>
            <div class="column-dbc"></div>
            <h2>模拟测试</h2>
            <div class="column-dbc"></div>
            <h2>真题测试</h2>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <a class="column-ab" href="#">初级乐理基础知识配套强化</a>
            <div class="clear"></div>
            <div class="column-dbc"></div>
            <h2>难点解答</h2>
            <a class="column-nd" href="#">
                <img src="/assets/img/column-test.jpg" width="200" height="150" />
                <div class="column-dinan">
                    <p>标题标题标题标题</p>
                    <p>作者</p>
                </div>
            </a>
            <a class="column-nd" href="#">
                <img src="/assets/img/column-test.jpg" width="200" height="150" />
            </a>
            <a class="column-nd" href="#">
                <img src="/assets/img/column-test.jpg" width="200" height="150" />
            </a>
        </div>
      	<div class="clear"></div>
    </div> <!-- /container -->
@stop