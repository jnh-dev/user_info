<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<h1>회원가입</h1>
<div>
    <!-- id -->
    <div>
        <input type="text" name="id" placeholder="이메일 형식의 아이디">
    </div>

    <!-- password -->
    <div>
        <input type="password" name="password" placeholder="비밀번호">
    </div>

    <!-- username -->
    <div>
        <input type="text" name="userName" placeholder="사용자 이름">
    </div>

    <br><input type="button" onclick="join();" value="가입">
    <a href="../../main">
        <input type="button" value="메인으로">
    </a>
</div>

<script>
    function join() {
        let data = {
            id : $('input[name="id"]').val(),
            password : $('input[name="password"]').val(),
            userName : $('input[name="userName"]').val(),
        };

        $.ajax({
            url : './join/add',
            type : 'post',
            data : data,
            dataType : 'JSON',
            success: function(data) {
                alert(data.resultMsg);
                if (data.result == true) {
                    location.href = '../../Main';
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
</script>
