import ProgressBar from "./ProgressBar";

interface DiagnosisHeaderProps {
  index: number;
  setIndex: (index: number) => void;
}

function DiagnosisHeader({ index, setIndex }: DiagnosisHeaderProps) {
  return (
    <div className="flex flex-col gap-4">
      <ProgressBar index={index} />
      <button
        className="cursor-pointer self-start text-xs text-neutral-600 hover:underline"
        onClick={() => {
          if (index > 0) {
            setIndex(index - 1);
          }
        }}
      >
        &larr;&nbsp;戻る
      </button>
    </div>
  );
}

export default DiagnosisHeader;
