import { getQuestion } from "../config/QuestionConfig";
import { Button } from "./Button";
import SpinnerMini from "./SpinnerMini";

interface QuestionWrapperProps {
  title: string;
  number: number;
  children: React.ReactNode;
  using: string;
  onEdit?: () => void;
  onUpdate?: () => void;
  onCancel?: () => void;
  readOnly?: boolean;
  isUpdating?: boolean;
  isChanged?: boolean;
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
  isUpdating = false,
  isChanged = false,
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
        <div className="mb-9 flex flex-col">
          {children}
          {number === 12 && (
            <div className="mt-5">
              {(getQuestion(11)?.["notes"] ?? []).map(
                (note: string, idx: number) => (
                  <p className="text-sm text-neutral-700" key={idx}>
                    ※{idx + 1} &nbsp; {note}
                  </p>
                ),
              )}
            </div>
          )}
        </div>
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
          <div className="flex w-3/4 flex-col">
            {children}
            {number === 12 && (
              <div className="mt-5">
                {(getQuestion(11)?.["notes"] ?? []).map(
                  (note: string, idx: number) => (
                    <p className="text-sm text-neutral-700" key={idx}>
                      ※{idx + 1} &nbsp;{note}
                    </p>
                  ),
                )}
              </div>
            )}
          </div>

          {readOnly && (
            <button
              className="absolute right-0 bottom-0 z-50 cursor-pointer text-sm font-medium text-neutral-800 underline"
              onClick={onEdit}
            >
              変更する
            </button>
          )}

          {!readOnly && (
            <div className="absolute right-0 bottom-0 z-50 flex gap-3">
              <Button
                variant="fillPrimary"
                size="xs"
                onClick={onUpdate}
                disabled={!isChanged}
              >
                {isUpdating ? <SpinnerMini /> : "更新する"}
              </Button>
              <Button variant="outlinePrimary" size="xs" onClick={onCancel}>
                キャンセル
              </Button>
            </div>
          )}
        </div>
      </div>
    );
  }
}

export default QuestionWrapper;
