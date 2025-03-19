import { useState } from "react";
import DiagnosisHeader from "./DiagnosisHeader";
import { Button } from "../../components/Button";
import DiagnosisForm from "./DiagnosisForm";

function DiagnosisSection() {
  const [index, setIndex] = useState<number>(0);

  return (
    <section className="h-full w-full rounded-xl bg-slate-50 px-8 py-7 shadow-lg">
      <div className="flex flex-col gap-12">
        <DiagnosisHeader index={index} setIndex={setIndex} />

        <div className="flex w-1/2 flex-col gap-12 self-center">
          <DiagnosisForm index={index} />
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
  );
}

export default DiagnosisSection;
