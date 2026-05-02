<div style="font-family: sans-serif; padding: 20px; max-width: 800px; margin: auto; border: 1px solid #ddd;">
    <h2>[[ (@me).name ]] 님의 마이페이지</h2>
    <p>포인트: <strong>[[ (@me).point.money() ]]</strong> P</p>
    
    <hr>

    <h3>최근 접속 로그</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <tr style="background: #f4f4f4;">
            <th style="padding: 10px; border: 1px solid #ddd;">번호</th>
            <th style="padding: 10px; border: 1px solid #ddd;">IP</th>
            <th style="padding: 10px; border: 1px solid #ddd;">메모</th>
            <th style="padding: 10px; border: 1px solid #ddd;">날짜</th>
        </tr>
        <?php foreach(@logs as @row): ?>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">{{ (@row).idx }}</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ (@row).ip }}</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ (@row).memo }}</td>
            <td style="padding: 10px; border: 1px solid #ddd; font-size: 0.9em; color: #666;">{{ (@row).regdate }}</td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>