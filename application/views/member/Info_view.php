<h1>회원정보 조회</h1>
<?php if ( ! empty($userInfo->id)): ?>
    <div>
        <?php echo "{$userInfo->userName}({$userInfo->id}) 님, 환영합니다."; ?>
        <br>
        <?php echo "(직전로그인 : {$this->session->userdata('login_time')})"; ?>
    </div>
<?php else: ?>
    error 401
<?php endif; ?>

<br><br>
<a href="../../main">
    <input type="button" value="메인으로">
</a>
