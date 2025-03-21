import { NestedRadioScore } from "../types/diagnosis";

interface NestedRadioQuestionProps {
  options: Record<string, string | { label: string }>;
  value: NestedRadioScore;
  onChange: (newValue: NestedRadioScore) => void;
  perOptions?: Record<string, string>;
  timesOptions?: Record<string, string>;
  readOnly?: boolean;
}

function NestedRadioQuestion({
  options,
  value = {},
  onChange,
  perOptions = {},
  timesOptions = {},
  readOnly = false,
}: NestedRadioQuestionProps) {
  const handleNestedRadioChange = (
    rack: string,
    checked: boolean,
    per?: number,
    times?: number,
  ) => {
    if (readOnly) return;

    const currentValue = value || {};
    const optionValue = options[rack];
    const optionKey =
      typeof optionValue === "object"
        ? (optionValue as { label: string }).label
        : (optionValue as string);

    onChange({
      ...currentValue,
      [optionKey]: {
        isChecked: checked,
        per: per ?? 0,
        times: times ?? 0,
      },
    });
  };

  const handleUsageRateChange = (rack: string, perIndex: number) => {
    if (readOnly) return;

    const currentValue = value || {};
    const optionValue = options[rack];
    const optionKey =
      typeof optionValue === "object"
        ? (optionValue as { label: string }).label
        : (optionValue as string);
    const currentOption = currentValue[optionKey] || { isChecked: true };

    onChange({
      ...currentValue,
      [optionKey]: {
        ...currentOption,
        isChecked: true,
        per: perIndex,
      },
    });
  };

  const handleVentilationChange = (rack: string, timesIndex: number) => {
    if (readOnly) return;

    const currentValue = value || {};
    const optionValue = options[rack];
    const optionKey =
      typeof optionValue === "object"
        ? (optionValue as { label: string }).label
        : (optionValue as string);
    const currentOption = currentValue[optionKey] || { isChecked: true };

    onChange({
      ...currentValue,
      [optionKey]: {
        ...currentOption,
        isChecked: true,
        times: timesIndex,
      },
    });
  };

  return (
    <>
      {Object.entries(options).map(([key, optionValue]) => {
        const isNested = typeof optionValue === "object";
        const optionKey = isNested
          ? (optionValue as { label: string }).label
          : (optionValue as string);
        const option = value[optionKey] || { isChecked: false };
        const isChecked = option.isChecked !== false;

        return (
          <div key={key} className="mb-4">
            <label className="flex h-12 items-center gap-2">
              <input
                type="checkbox"
                id={`option-${key}`}
                checked={isChecked}
                onChange={(e) => handleNestedRadioChange(key, e.target.checked)}
                className="h-4 w-4 rounded border-2 border-neutral-400 text-cyan-700 accent-cyan-700"
                disabled={readOnly}
              />
              <span className="text-neutral-700">
                {isNested
                  ? (optionValue as { label: string }).label
                  : (optionValue as string)}
              </span>
            </label>

            {isChecked && (
              <div className="ml-6">
                {/* 使用割合セクション */}
                <div className="w-full">
                  <div className="flex h-12 justify-between pr-4">
                    <div className="flex-1 opacity-0">使用割合</div>
                    {Object.entries(perOptions).map(([, perValue], idx) => (
                      <div
                        key={idx}
                        className="flex flex-1 items-center justify-center"
                      >
                        <div className="text-base text-neutral-700">
                          {perValue as string}
                        </div>
                      </div>
                    ))}
                  </div>
                  <div className="flex h-12 justify-between bg-neutral-100 pr-4">
                    <div className="flex-1 self-center text-base text-neutral-700">
                      使用割合
                    </div>
                    {Object.entries(perOptions).map(([,], idx) => {
                      const currentOption = value[optionKey] || {
                        isChecked: false,
                        per: 0,
                      };
                      return (
                        <div
                          key={idx}
                          className="flex flex-1 items-center justify-center"
                        >
                          <div className="text-base">
                            <input
                              type="radio"
                              name={`usage-${key}`}
                              checked={currentOption.per === idx}
                              onChange={() => handleUsageRateChange(key, idx)}
                              className="h-4 w-4 rounded-full border-2 border-neutral-400 text-cyan-700 accent-cyan-700"
                              disabled={readOnly}
                            />
                          </div>
                        </div>
                      );
                    })}
                  </div>
                </div>

                {/* 換気回数セクション */}
                <div className="w-full">
                  <div className="flex h-12 justify-between pr-4">
                    <div className="flex-1 opacity-0">飼育室の換気回数</div>
                    {Object.entries(timesOptions).map(([, timesValue], idx) => (
                      <div
                        key={idx}
                        className="flex flex-1 items-center justify-center"
                      >
                        <div className="text-base text-neutral-700">
                          {timesValue as string}
                        </div>
                      </div>
                    ))}
                  </div>
                  <div className="flex h-12 justify-between bg-neutral-100 pr-4">
                    <div className="flex-1 self-center text-base text-neutral-700">
                      飼育室の換気回数
                    </div>
                    {Object.entries(timesOptions).map(([,], idx) => {
                      const currentOption = value[optionKey] || {
                        isChecked: false,
                        times: 0,
                      };
                      return (
                        <div
                          key={idx}
                          className="flex flex-1 items-center justify-center"
                        >
                          <div key={idx} className="text-base">
                            <input
                              type="radio"
                              name={`ventilation-${key}`}
                              checked={currentOption.times === idx}
                              onChange={() => handleVentilationChange(key, idx)}
                              className="h-4 w-4 rounded-full border-2 border-neutral-400 text-cyan-700 accent-cyan-700"
                              disabled={readOnly}
                            />
                          </div>
                        </div>
                      );
                    })}
                  </div>
                </div>
              </div>
            )}
          </div>
        );
      })}
    </>
  );
}

export default NestedRadioQuestion;
