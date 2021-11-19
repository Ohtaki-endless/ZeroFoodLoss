    let count;
    // 売切表示を初期状態では非表示にしておく
    document.getElementById("sold-out").style.display ="none";
    
    // 時間の計算
    function countDown(goal) {
        const now = new Date();
        // 期限時間ー現在の時間
        const left = goal*1000 - now.getTime();
        if (left > 0) {
            const sec = Math.floor(left / 1000) % 60;
            const min = Math.floor(left / 1000 / 60) % 60;
            const hours = Math.floor(left / 1000 / 60 / 60) % 24;
            const days = Math.floor(left / 1000 / 60 / 60 / 24);
            count = { days: days, hours: hours, min: min, sec: sec };
        } else {
            count = { days: 0, hours: 0, min: 0, sec: 0 };
        }
        return count;
    }
        
    //Timer処理
    function setCountDown() {
        let counter = countDown(goal);
        let end = 0;
        const countDownTimer = setTimeout(setCountDown, 1000);
        
        for (let item in counter) {
            document.getElementById(item).textContent = counter[item];
            end += parseInt(counter[item]);
        }
        // タイマーがゼロになったときの処理
        if (end === 0) {
            clearTimeout(countDownTimer);
            // 販売中の要素を非表示
            document.getElementById("sale").style.display ="none";
            // 売り切れの要素を表示
            document.getElementById("sold-out").style.display ="block";
        }
    }
    // タイマーの実行
    setCountDown();
    
    
    
    function deletePost(){
        'use strict'
        if (window.confirm('削除すると復元できません。\n本当に削除しますか？')) {
            document.getElementById('post_delete').submit();
        }
    }
    
    
    function deleteComment(e){
        'use strict'
        if (window.confirm('削除すると復元できません。\n本当に削除しますか？')) {
            document.getElementById('comment_' + e.dataset.id + '_delete').submit();
        }
    }
