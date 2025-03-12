function EvaluationBasis() {
  return (
    <div className="flex flex-col items-center justify-center gap-15 bg-linear-to-b from-neutral-100 to-slate-100 px-28 py-20">
      <h2 className="mb-5 text-4xl font-black text-neutral-950">
        評価軸について
      </h2>
      <div className="grid w-full grid-cols-2 gap-x-5 gap-y-10">
        <div className="flex flex-col self-stretch">
          <div className="self-start rounded-t-lg bg-cyan-900 px-5 py-2.5 text-base font-bold text-neutral-50">
            原則１
          </div>
          <div className="flex h-full w-full flex-col justify-between gap-5 rounded-tr-lg rounded-b-lg border-t-[3px] border-cyan-900 bg-white p-6 text-neutral-950 shadow-md">
            <div>
              <h4 className="mb-5 text-xl font-bold text-neutral-950">
                動物の飼育目的に叶っていること
              </h4>
              <p className="text-base font-normal">
                設置する実験動物施設は，収容する動物種や施設の使用目的について十分に吟味されていなくてはならないと共に，動物実験の目的の可変性に対応したフレキシビリティが求められるとされています。
              </p>
            </div>
            <div className="flex h-full flex-col gap-2.5 rounded-l-lg border-l-[3px] border-cyan-900 bg-slate-100 p-5">
              <h5 className="font-bold">
                &lt;原則１の基準ポイントについて&gt;
              </h5>
              <p>
                本ツールでは，評価対象施設が飼育動物種や使用目的について十分に検討のうえ建設されているとして，基本的に基準ポイントは満足しているものと見做します。その上で，施設の使用過程で生じているかもしれない環境設定の不備や，施設のハード面でのフレキシビリティへの配慮などによって，ポイントを加減しています。
              </p>
            </div>
          </div>
        </div>
        <div className="flex flex-col self-stretch">
          <div className="self-start rounded-t-lg bg-cyan-900 px-5 py-2.5 text-base font-bold text-neutral-50">
            原則２
          </div>
          <div className="flex h-full w-full flex-col justify-between gap-5 rounded-tr-lg rounded-b-lg border-t-[3px] border-cyan-900 bg-white p-6 text-neutral-950 shadow-md">
            <div>
              <h4 className="mb-5 text-xl font-bold text-neutral-950">
                動物に対して快適で衛生的な条件が維持されること
              </h4>
              <p className="text-base font-normal">
                各種の環境要因(温度，湿度，気流および空気清浄度等)が適切に維持され，衛生的で，総合的な感染病発生防止対策がとられていることとされています。
              </p>
            </div>
            <div className="flex flex-col gap-2.5 rounded-l-lg border-l-[3px] border-cyan-900 bg-slate-100 p-5">
              <h5 className="font-bold">
                &lt;原則２の基準ポイントについて&gt;
              </h5>
              <p>
                本ツールでは，評価対象施設において飼育動物にとって適切な環境が維持されているものとして，基本的に基準ポイントは満足しているものと見做します。その上で，飼育器材に適した環境設定や建築および建築設備からの感染対策などを評価し，ポイントを加減しています。
              </p>
            </div>
          </div>
        </div>
        <div className="flex flex-col self-stretch">
          <div className="self-start rounded-t-lg bg-cyan-900 px-5 py-2.5 text-base font-bold text-neutral-50">
            原則３
          </div>
          <div className="flex h-full w-full flex-col justify-between gap-5 rounded-tr-lg rounded-b-lg border-t-[3px] border-cyan-900 bg-white p-6 text-neutral-950 shadow-md">
            <div>
              <h4 className="mb-5 text-xl font-bold text-neutral-950">
                施設内で作業する人に対して，快適で衛生的な条件に維持されること
              </h4>
              <p className="text-base font-normal">
                作業環境として快適で衛生的であるばかりでなく，労働安全衛生の面から実験動物アレルギー対策や感染症対策が十分にとられている必要があるとされています。
              </p>
            </div>
            <div className="flex h-full flex-col gap-2.5 rounded-l-lg border-l-[3px] border-cyan-900 bg-slate-100 p-5">
              <h5 className="font-bold">
                &lt;原則３の基準ポイントについて&gt;
              </h5>
              <p>
                本ツールでは，評価対象施設において適切な作業環境の維持と実験動物アレルギー等への対策が実施されているものとし，基本的に基準ポイントは満足しているものと見做します。その上で，飼育器材と環境設定の組み合わせや，建築及び建築設備のハードを支えるソフト面で対応などについて評価し，ポイントを加減しています。
              </p>
            </div>
          </div>
        </div>
        <div className="flex flex-col self-stretch">
          <div className="self-start rounded-t-lg bg-cyan-900 px-5 py-2.5 text-base font-bold text-neutral-50">
            原則４
          </div>
          <div className="flex h-full w-full flex-col justify-between gap-5 rounded-tr-lg rounded-b-lg border-t-[3px] border-cyan-900 bg-white p-6 text-neutral-950 shadow-md">
            <div>
              <h4 className="mb-5 text-xl font-bold text-neutral-950">
                施設周辺への環境保全が図られていること
              </h4>
              <p className="text-base font-normal">
                施設周辺への微生物やRI物質の拡散防止は言うまでもなく，各種環境法による公害防止対策が必要です。また逸走防止等に特段の配慮が必要であるとされています。
              </p>
            </div>
            <div className="flex h-full flex-col gap-2.5 rounded-l-lg border-l-[3px] border-cyan-900 bg-slate-100 p-5">
              <h5 className="font-bold">
                &lt;原則４の基準ポイントについて&gt;
              </h5>
              <p>
                本ツールでは，法的な順守事項は全て満たしていなくてはなりませんから，その点において評価対象施設は基準ポイントを満足していると見做します。その上で，飼育器材や建築，またソフト面での対応について評価し，ポイントを加減しています。
              </p>
            </div>
          </div>
        </div>
        <div className="flex flex-col self-stretch">
          <div className="self-start rounded-t-lg bg-cyan-900 px-5 py-2.5 text-base font-bold text-neutral-50">
            原則５
          </div>
          <div className="flex h-full w-full flex-col justify-between gap-5 rounded-tr-lg rounded-b-lg border-t-[3px] border-cyan-900 bg-white p-6 text-neutral-950 shadow-md">
            <div>
              <h4 className="mb-5 text-xl font-bold text-neutral-950">
                施設周辺への環境保全が図られていること
              </h4>
              <p className="text-base font-normal">
                実験動物施設の運用には莫大なエネルギーが必要とされるので，可能な範囲で省エネルギー手法の導入を検討することが重要です。さらに周辺環境のみならず地球環境への配慮も求められる性能として重要な要素です。
              </p>
            </div>
            <div className="flex flex-col gap-2.5 rounded-l-lg border-l-[3px] border-cyan-900 bg-slate-100 p-5">
              <h5 className="font-bold">
                &lt;原則５の基準ポイントについて&gt;
              </h5>
              <p>
                本ツールでは，評価対象施設が運用に必要なエネルギーを確保でき，使用目的や環境設定の維持に十分な性能を持った設備を導入していて，基本的に基準ポイントは満足しているものと見做します。その上で，飼育器材や環境設定，省エネルギー技術の導入状況などを評価し，ポイントを加減しています。
              </p>
            </div>
          </div>
        </div>
        <div className="flex flex-col self-stretch">
          <div className="self-start rounded-t-lg bg-cyan-900 px-5 py-2.5 text-base font-bold text-neutral-50">
            原則DP
          </div>
          <div className="flex h-full w-full flex-col justify-between gap-5 rounded-tr-lg rounded-b-lg border-t-[3px] border-cyan-900 bg-white p-6 text-neutral-950 shadow-md">
            <div>
              <h4 className="mb-5 text-xl font-bold text-neutral-950">
                緊急時・災害時の対策，事業継続計画の策定が実施されていること
              </h4>
              <p className="text-base font-normal">
                想定される緊急事態や災害への備えがソフト・ハードの両面で必要です。被災・罹災時だけでなく，正常化までの期間を乗り切るための計画・準備をしておくことも重要となってきます。
              </p>
            </div>
            <div className="flex flex-col gap-2.5 rounded-l-lg border-l-[3px] border-cyan-900 bg-slate-100 p-5">
              <h5 className="font-bold">
                &lt;原則DPの基準ポイントについて&gt;
              </h5>
              <p>
                本ツールでは，建築および建築設備などのハードについては，施設それぞれの考え方で対策が導入されていると考えられ，基本的に基準ポイントは満足しているものと見做します。その上で，主として飼育室内での対策やソフト面での準備を評価し，ポイントを加減しています。
              </p>
            </div>
          </div>
        </div>
      </div>
      <p className="text-sm text-neutral-600">
        注）なお現時点で，本ツールは小動物飼育に対応した評価に限定しています。中大型動物や哺乳動物以外の生物については検討中です。
        <br />
        注）本ツールでは、メールアドレス等を含む使用者に関する情報は一切収集いたしません。
      </p>
    </div>
  );
}

export default EvaluationBasis;
