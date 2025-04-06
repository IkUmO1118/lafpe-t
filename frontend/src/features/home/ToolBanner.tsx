function ToolBanner() {
  return (
    <div className="flex flex-col items-center justify-center gap-8 bg-slate-100 py-16 text-neutral-800">
      <h3 className="text-[28px] font-medium">
        実験動物施設性能診断ツールとは
      </h3>
      <div className="flex flex-col items-center text-lg font-normal">
        <p>
          このツールは、建築的・設備的な観点から施設性能を多面的に捉え、用途や運営方針に合致した性能を有しているかを把
        </p>
        <p>
          握することを意図しています。自施設の現状を再確認することで、施設の最適化を図りより適正な運営方針へと繋げることや
        </p>
        <p>
          新築計画時の構想・目標設定、改修時の検討材料としての活用を期待するものです。
        </p>
        <p>
          本ツールは、ガイドライン（2007年版,日本建築学会編）に述べられている5つの基本原則に、BCPを含む災害時のデザスタープラン
        </p>
        <p>
          （以下,DP）を加えた6つの軸について、施設の建築及び建築設備の運用状況に関する評価を行います。
        </p>
      </div>
    </div>
  );
}

export default ToolBanner;
