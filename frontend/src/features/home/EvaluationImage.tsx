function EvaluationImage() {
  return (
    <div className="flex flex-col items-center justify-center gap-14 py-20">
      <h2 className="text-4xl font-black text-neutral-950">
        評価結果の表示イメージ
      </h2>
      <img
        src="/images/LAFPE-T_display-image.png"
        alt="display image"
        className="w-[600px]"
      />
    </div>
  );
}

export default EvaluationImage;
