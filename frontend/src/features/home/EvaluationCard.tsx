interface EvaluationCardProp {
  index: number;
  title: string;
  description: string;
  point: string;
}

function EvaluationCard({
  index,
  title,
  description,
  point,
}: EvaluationCardProp) {
  return (
    <div className="flex flex-col self-stretch">
      <div className="self-start rounded-t-lg bg-cyan-900 px-5 py-2.5 text-base font-bold text-neutral-50">
        原則{index <= 5 ? index : "DP"}
      </div>
      <div className="flex h-full w-full flex-col justify-between gap-5 rounded-tr-lg rounded-b-lg border-t-[3px] border-cyan-900 bg-white p-6 text-neutral-950 shadow-md">
        <div>
          <h4 className="mb-5 text-xl font-bold text-neutral-950">{title}</h4>
          <p className="text-base font-normal">{description}</p>
        </div>
        <div className="flex flex-col gap-2.5 rounded-l-lg border-l-[3px] border-cyan-900 bg-slate-100 p-5">
          <h5 className="font-bold">
            &lt;原則{index <= 5 ? index : "DP"}の基準ポイントについて&gt;
          </h5>
          <p className="whitespace-pre-wrap">{point}</p>
        </div>
      </div>
    </div>
  );
}

export default EvaluationCard;
