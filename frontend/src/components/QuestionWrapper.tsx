import { Button } from "./Button";

interface QuestionWrapperProps {
  title: string;
  number?: number;
  children: React.ReactNode;
  using: string;
  onEdit?: () => void;
  onUpdate?: () => void;
  onCancel?: () => void;
  readOnly?: boolean;
}

export function QuestionWrapper({
  title,
  number,
  children,
  using,
  onEdit,
  onUpdate,
  onCancel,
  readOnly = true,
}: QuestionWrapperProps) {
  if (using === "diagnosis") {
    return (
      <div className="flex flex-col gap-3">
        <div className="self-center text-sm font-bold text-cyan-700">
          設問&nbsp;{number}
        </div>
        <p className="mb-4 border-b-2 border-dotted border-neutral-300 pb-2.5 text-base font-bold text-neutral-700">
          {title}
        </p>
        <div className="mb-9">{children}</div>
      </div>
    );
  }

  if (using === "result") {
    return (
      <div
        className={`${!readOnly ? "bg-neutral-50" : "bg-transparent"} flex flex-col gap-2 border-b border-neutral-300 p-6`}
      >
        <p className="text-base font-medium text-neutral-700">
          設問{number}： {title}
        </p>
        <div className="relative">
          <div className="w-3/4">{children}</div>

          {readOnly && (
            <button
              className="absolute right-0 bottom-0 z-50 text-sm font-medium text-neutral-800 underline"
              onClick={onEdit}
            >
              変更する
            </button>
          )}

          {!readOnly && (
            <div className="absolute right-0 bottom-0 z-50 flex gap-3">
              <Button variant="fillPrimary" size="xl2" onClick={onUpdate}>
                更新する
              </Button>
              <Button variant="outlinePrimary" size="xl2" onClick={onCancel}>
                クリア
              </Button>
            </div>
          )}
        </div>
      </div>
    );
  }
}

export default QuestionWrapper;
