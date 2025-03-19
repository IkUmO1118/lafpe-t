import { forwardRef, ForwardedRef } from "react";

const EvaluationImage = forwardRef(function EvaluationImage(
  _props,
  ref: ForwardedRef<HTMLDivElement>,
) {
  return (
    <div
      ref={ref}
      className="flex flex-col items-center justify-center gap-14 py-20"
    >
      <h2 className="text-4xl font-black text-neutral-950">
        評価結果の表示イメージ
      </h2>
      <img
        src="/images/lafpe-t_graph.png"
        alt="display image"
        className="w-[600px]"
      />
    </div>
  );
});

export default EvaluationImage;
