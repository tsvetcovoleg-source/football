<?php
require_once __DIR__ . '/includes/auth.php';
requireLogin();

$pageTitle = 'Regulamentul turneului';
require __DIR__ . '/includes/header.php';
?>
<section class="hero regulation-hero">
    <div>
        <p class="eyebrow">Regulament intern</p>
        <h1>REGULAMENT</h1>
        <p>Privind organizarea și desfășurarea Turneului intern de prognozare a rezultatelor meciurilor din cadrul Campionatului Mondial de Fotbal.</p>
    </div>
</section>

<article class="regulation-card">
    <section class="regulation-section">
        <h2>1. Dispoziții generale</h2>
        <p>1.1. Prezentul Regulament stabilește cadrul intern privind participarea, formularea, evidența, validarea și evaluarea prognozelor aferente meciurilor din cadrul Campionatului Mondial de Fotbal.</p>
        <p>1.2. Scopul prezentului Regulament constă în asigurarea unui proces transparent, echitabil și controlabil de determinare a celui mai competent, inspirat și/sau norocos prognozist.</p>
        <p>1.3. Participarea la Turneu presupune acceptarea integrală și necondiționată a prevederilor prezentului Regulament, inclusiv a consecințelor financiare și sociale aferente poziției ocupate în clasamentul final.</p>
        <p>1.4. Turneul are caracter recreativ, neoficial și competitiv, însă toate prognozele vor fi tratate cu maximă seriozitate, în conformitate cu cele mai înalte standarde de responsabilitate sportivă și disciplină pronosticistică.</p>
    </section>

    <section class="regulation-section">
        <h2>2. Definiții</h2>
        <p>În sensul prezentului Regulament, următoarele noțiuni vor avea următoarele semnificații:</p>
        <p>2.1. <strong>Participant</strong> — persoana admisă în Turneu, căreia i-a fost atribuit un login individual pentru introducerea prognozelor.</p>
        <p>2.2. <strong>Prognoză</strong> — estimarea rezultatului unui meci, exprimată prin indicarea scorului exact al acestuia.</p>
        <p>2.3. <strong>Meci</strong> — eveniment sportiv inclus în calendarul Turneului și disponibil pentru formularea prognozelor.</p>
        <p>2.4. <strong>Rezultat real</strong> — scorul final al meciului, introdus în sistem după încheierea acestuia. Pentru meciurile din fazele eliminatorii, rezultatul real luat în considerare este scorul înregistrat la finalul celor două reprize regulamentare; prelungirile și loviturile de departajare nu se iau în calcul.</p>
        <p>2.5. <strong>Clasament</strong> — evidența cumulativă a punctelor obținute de Participanți în baza prognozelor formulate.</p>
        <p>2.6. <strong>Organizator</strong> — persoana responsabilă de administrarea Turneului, introducerea meciurilor, validarea rezultatelor și menținerea unei aparențe rezonabile de ordine.</p>
    </section>

    <section class="regulation-section">
        <h2>3. Înregistrarea Participanților</h2>
        <p>3.1. Accesul Participanților în sistem se realizează în baza unui login individual și a unei parole.</p>
        <p>3.2. Loginul este creat de Organizator.</p>
        <p>3.3. Parola este generată pentru fiecare Participant și transmisă acestuia în mod individual.</p>
        <p>3.4. Participantul poartă responsabilitate deplină pentru utilizarea loginului său, inclusiv pentru prognozele introduse sub acest login, indiferent dacă acestea au fost formulate în stare de luciditate, optimism excesiv sau patriotism nejustificat.</p>
    </section>

    <section class="regulation-section">
        <h2>4. Formularea prognozelor</h2>
        <p>4.1. Pentru fiecare meci, Participantul indică scorul estimat.</p>
        <p>4.2. Prognoza poate fi introdusă numai până la ora începerii meciului.</p>
        <p>4.3. După începerea meciului, sistemul blochează posibilitatea introducerii sau modificării prognozei.</p>
        <p>4.4. Modificarea prognozei după începerea meciului este interzisă.</p>
        <p>4.5. Orice încercare de modificare a prognozei după începerea meciului va fi tratată ca tentativă de influențare neautorizată a procesului sportiv-analitic și poate atrage după sine dezaprobarea colectivului.</p>
        <p>4.6. Participantul este obligat să se asigure, din timp, că prognoza a fost introdusă corect. Invocarea motivelor de tipul „am uitat”, „nu s-a salvat”, „voiam să pun alt scor” sau „eu de fapt așa am simțit” nu constituie temei pentru modificarea ulterioară a prognozei.</p>
    </section>

    <section class="regulation-section">
        <h2>5. Calcularea punctajului</h2>
        <p>5.1. Punctajul se acordă după introducerea rezultatului real al meciului.</p>
        <p>5.2. Punctele se acordă după cum urmează:</p>
        <ol class="alpha-list">
            <li>3 puncte — pentru prognozarea exactă a scorului meciului;</li>
            <li>2 puncte — pentru prognozarea corectă a rezultatului și a diferenței de goluri;</li>
            <li>1 punct — pentru prognozarea corectă doar a rezultatului meciului;</li>
            <li>0 puncte — în cazul în care prognoza nu corespunde niciuneia dintre situațiile menționate mai sus.</li>
        </ol>
        <p>5.3. Prin rezultat al meciului se înțelege:</p>
        <ol class="alpha-list">
            <li>victoria primei echipe;</li>
            <li>rezultatul de egalitate;</li>
            <li>victoria celei de-a doua echipe.</li>
        </ol>
        <p>5.4. În cazul meciurilor încheiate la egalitate, prognozarea egalității cu un alt scor decât cel real se punctează cu 2 puncte.</p>
        <p>5.5. Calcularea punctajului se efectuează automat de sistem sau, după caz, manual de Organizator, cu respectarea principiilor de bună-credință, echitate și interes general al mesei festive finale.</p>
    </section>

    <section class="regulation-section">
        <h2>6. Clasamentul Participanților</h2>
        <p>6.1. Clasamentul se formează în baza punctajului total acumulat de fiecare Participant.</p>
        <p>6.2. În caz de egalitate de puncte, pot fi luate în considerare criterii suplimentare, inclusiv:</p>
        <ol class="alpha-list">
            <li>numărul de scoruri exacte;</li>
            <li>numărul de prognoze evaluate cu 2 puncte;</li>
            <li>numărul total de prognoze formulate;</li>
            <li>gradul de încredere nejustificată manifestat înaintea meciurilor;</li>
            <li>alte criterii stabilite de Organizator, în limitele decenței și ale umorului colectiv.</li>
        </ol>
        <p>6.3. Clasamentul final se consideră definitiv după finalizarea ultimului meci inclus în Turneu și validarea tuturor rezultatelor.</p>
    </section>

    <section class="regulation-section">
        <h2>7. Transparența prognozelor</h2>
        <p>7.1. Participantul poate vizualiza propriile prognoze în orice moment.</p>
        <p>7.2. Prognozele altor Participanți devin vizibile pentru un anumit meci numai după ce Participantul și-a introdus propria prognoză pentru acel meci.</p>
        <p>7.3. În cazul în care Participantul nu a introdus prognoza pentru un meci, acesta poate vedea doar faptul existenței sau inexistenței prognozelor celorlalți Participanți, fără acces la conținutul acestora.</p>
        <p>7.4. Măsura prevăzută la pct. 7.2 și 7.3 are drept scop prevenirea copierii, influenței reciproce și a fenomenului cunoscut neoficial drept „lasă că pun și eu ca el”.</p>
    </section>

    <section class="regulation-section">
        <h2>8. Evenimentul final și contribuțiile Participanților</h2>
        <p>8.1. La finalul Turneului va fi organizat un eveniment comun cu caracter festiv, denumit în continuare <strong>Prieteneasca Adunare de Lichidare a Rezultatelor</strong>.</p>
        <p>8.2. Evenimentul menționat la pct. 8.1 va avea ca scop:</p>
        <ol class="alpha-list">
            <li>celebrarea câștigătorului;</li>
            <li>analiza retrospectivă a deciziilor eronate;</li>
            <li>justificarea prognozelor nereușite;</li>
            <li>consumul responsabil sau moderat-responsabil de băuturi și alte bunuri aferente.</li>
        </ol>
        <p>8.3. Contribuția financiară la evenimentul final se stabilește în funcție de locul ocupat în clasamentul final, după cum urmează:</p>
        <ol class="alpha-list">
            <li>locul 1 — nu contribuie financiar;</li>
            <li>locul 2 — contribuie cu 200 MDL;</li>
            <li>locul 3 — contribuie cu 250 MDL;</li>
            <li>fiecare loc următor contribuie cu o sumă majorată cu 50 MDL față de locul precedent.</li>
        </ol>
        <p>8.4. Formula generală de calcul pentru locurile începând cu locul 2 este:</p>
        <div class="formula-box">Contribuție = 200 MDL + (Locul ocupat - 2) × 50 MDL</div>
        <p>8.5. Prin excepție de la orice principiu moral invocat ulterior, locul 1 este scutit integral de contribuție, în temeiul performanței, inspirației și superiorității temporare demonstrate în cadrul Turneului.</p>
        <p>8.6. Participantul clasat pe ultimul loc nu va fi discriminat, dar poate fi menționat în mod repetat în cadrul evenimentului final, în limitele unui umor rezonabil.</p>
    </section>

    <section class="regulation-section">
        <h2>9. Situații speciale și soluționarea divergențelor</h2>
        <p>9.1. Orice situație neprevăzută de prezentul Regulament va fi analizată individual.</p>
        <p>9.2. În cazul apariției unor divergențe privind interpretarea prognozelor, calcularea punctajului, validarea rezultatelor sau alte aspecte conexe, se va urmări adoptarea unei soluții echitabile, proporționale și acceptabile pentru majoritatea persoanelor prezente.</p>
        <p>9.3. În cazuri complexe, sensibile sau cu impact reputațional asupra Participanților, decizia finală poate fi adoptată:</p>
        <ol class="alpha-list">
            <li>în biroul 704; sau</li>
            <li>în cadrul Consiliului Băncii.</li>
        </ol>
        <p>9.4. Deciziile adoptate conform pct. 9.3 sunt considerate definitive, obligatorii și, după caz, imposibil de contestat fără expunerea Participantului la glume suplimentare.</p>
    </section>

    <section class="regulation-section">
        <h2>10. Dispoziții finale</h2>
        <p>10.1. Prezentul Regulament intră în vigoare la data comunicării acestuia Participanților.</p>
        <p>10.2. Organizatorul își rezervă dreptul de a modifica prezentul Regulament în cazul în care realitatea sportivă, tehnică sau socială o va impune.</p>
        <p>10.3. Modificările Regulamentului nu pot avea ca scop favorizarea directă a unui Participant, cu excepția cazurilor în care acest lucru este suficient de amuzant și acceptat tacit de grup.</p>
        <p>10.4. Participarea la Turneu confirmă că Participantul a citit, a înțeles și, cel mai probabil, va contesta la un moment dat prevederile prezentului Regulament.</p>
        <p>10.5. În toate aspectele nereglementate expres, se aplică principiile bunei dispoziții, fair-play-ului, respectului reciproc și acceptării faptului că fotbalul rămâne imprevizibil, iar prognozele — cu atât mai mult.</p>
    </section>
</article>
<?php require __DIR__ . '/includes/footer.php'; ?>
