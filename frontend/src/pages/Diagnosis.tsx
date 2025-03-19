import { useState } from "react";
import { Button } from "../components/Button";
import DiagnosisHeader from "../features/diagnosis/DiagnosisHeader";

function Diagnosis() {
  const [index, setIndex] = useState<number>(0);

  return (
    <main className="min-h-screen w-full bg-neutral-400 px-12 py-11">
      <section className="h-full w-full rounded-xl bg-slate-50 px-8 py-7 shadow-lg">
        <div className="flex flex-col gap-12">
          <DiagnosisHeader index={index} setIndex={setIndex} />

          <div className="flex w-1/2 flex-col gap-7 self-center">
            <div className="flex flex-col gap-3">
              <div className="self-center text-sm font-bold text-cyan-700">
                設問&nbsp;{index + 1}
              </div>
              <p className="mb-2.5 border-b-2 border-dotted border-neutral-300 pb-2.5 text-base font-bold text-neutral-700">
                施設の廊下方式を選択してください（複数選択可）
              </p>
            </div>
            <div className="mb-5">form</div>
            <Button
              className="self-center py-3 font-medium"
              onClick={() => {
                if (index < 12) {
                  setIndex((i) => i + 1);
                }
              }}
            >
              次の設問へ&nbsp;&nbsp;&rarr;
            </Button>
          </div>
        </div>
      </section>
    </main>
  );
}

export default Diagnosis;
