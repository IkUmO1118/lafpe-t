import { Button } from "../../components/Button";
import { getQuestion } from "../../config/QuestionConfig";
import { CheckboxScore, NestedRadioScore } from "../../types/diagnosis";
import useDiagnosisForm from "./useDiagnosisForm";

interface DiagnosisFormProps {
  index: number;
  setIndex: (index: number) => void;
}

function DiagnosisForm({ index, setIndex }: DiagnosisFormProps) {
  const question = getQuestion(index);
  const questionNumber = `Q${index + 1}`;
  const { selectedValue, setSelectedValue, handleSubmit } =
    useDiagnosisForm(questionNumber);

  const handleCheckboxChange = (optionIndex: number) => {
    const currentValue = Array.isArray(selectedValue)
      ? (selectedValue as CheckboxScore)
      : [];

    if (currentValue.includes(optionIndex)) {
      setSelectedValue(currentValue.filter((val) => val !== optionIndex));
    } else {
      setSelectedValue([...currentValue, optionIndex]);
    }
  };

  const handleRadioChange = (optionIndex: number) => {
    setSelectedValue(optionIndex);
  };

  const handleNestedRadioChange = (
    rack: string,
    checked: boolean,
    per?: number,
    times?: number,
  ) => {
    const currentValue = (selectedValue as NestedRadioScore) || {};

    setSelectedValue({
      ...currentValue,
      [question.option[rack]]: {
        isChecked: checked,
        per: per ?? 0,
        times: times ?? 0,
      },
    });
  };

  // First, we need to add these handlers below handleNestedRadioChange

  const handleUsageRateChange = (rack: string, perIndex: number) => {
    const currentValue = (selectedValue as NestedRadioScore) || {};
    const optionValue = currentValue[question.option[rack]] || {
      isChecked: true,
    };

    setSelectedValue({
      ...currentValue,
      [question.option[rack]]: {
        ...optionValue,
        isChecked: true,
        per: perIndex,
      },
    });
  };

  const handleVentilationChange = (rack: string, timesIndex: number) => {
    const currentValue = (selectedValue as NestedRadioScore) || {};
    const optionValue = currentValue[question.option[rack]] || {
      isChecked: true,
    };

    setSelectedValue({
      ...currentValue,
      [question.option[rack]]: {
        ...optionValue,
        isChecked: true,
        times: timesIndex,
      },
    });
  };

  // 質問タイプに応じたレンダリング
  const renderFormInputs = () => {
    // CheckboxScore用の入力（Q1, Q2, Q7-Q13）
    if (
      questionNumber === "Q1" ||
      questionNumber === "Q2" ||
      (parseInt(questionNumber.slice(1)) >= 7 &&
        parseInt(questionNumber.slice(1)) <= 13)
    ) {
      // Ensure selectedValue is treated as an array
      const checkboxValue = Array.isArray(selectedValue)
        ? (selectedValue as CheckboxScore)
        : [];

      return Object.entries(question.option).map(
        ([key, value], optionIndex) => (
          <label key={key} className="flex h-12 items-center gap-2">
            <input
              type="checkbox"
              id={`option-${key}`}
              checked={checkboxValue.includes(optionIndex)}
              onChange={() => handleCheckboxChange(optionIndex)}
              className="h-4 w-4 rounded border-2 border-neutral-400 text-cyan-700 accent-cyan-700"
            />
            <span className="text-neutral-700">{value as string}</span>
          </label>
        ),
      );
    }

    // RadioScore用の入力（Q4, Q5, Q6）
    else if (["Q4", "Q5", "Q6"].includes(questionNumber)) {
      return Object.entries(question.option).map(
        ([key, optionText], optionIndex) => (
          <label key={key} className="flex h-12 items-center gap-2">
            <input
              type="radio"
              id={`option-${key}`}
              name={questionNumber}
              checked={selectedValue === optionIndex}
              onChange={() => handleRadioChange(optionIndex)}
              className="h-4 w-4 rounded-full border-2 border-neutral-400 text-cyan-700 accent-cyan-700"
            />
            <span className="text-neutral-700">{optionText as string}</span>
          </label>
        ),
      );
    }

    // NestedRadioScore用の入力（Q3）
    else if (questionNumber === "Q3") {
      const nestedValue = (selectedValue as NestedRadioScore) || {};

      return Object.entries(question.option).map(([key, value]) => {
        const isNested = typeof value === "object";
        const optionValue = nestedValue[value] || { isChecked: false };
        const isChecked = optionValue.isChecked !== false;

        return (
          <div key={key} className="mb-4">
            <label className="flex h-12 items-center gap-2">
              <input
                type="checkbox"
                id={`option-${key}`}
                checked={isChecked}
                onChange={(e) => handleNestedRadioChange(key, e.target.checked)}
                className="h-4 w-4 rounded border-2 border-neutral-400 text-cyan-700 accent-cyan-700"
              />
              <span className="text-neutral-700">
                {isNested
                  ? (value as { label: string }).label
                  : (value as string)}
              </span>
            </label>

            {isChecked && (
              <div className="ml-6">
                <div className="w-full">
                  <div className="flex h-12 justify-between pr-4">
                    <div className="flex-1 opacity-0">使用割合</div>
                    {Object.entries(question.per || {}).map(
                      ([, perValue], idx) => (
                        <div className="flex flex-1 items-center justify-center">
                          <div key={idx} className="text-base text-neutral-700">
                            {perValue as string}
                          </div>
                        </div>
                      ),
                    )}
                  </div>
                  <div className="flex h-12 justify-between bg-neutral-100 pr-4">
                    <div className="flex-1 self-center text-base text-neutral-700">
                      使用割合
                    </div>
                    {Object.entries(question.per || {}).map(([,], idx) => {
                      const optionValue = nestedValue[value] || {
                        isChecked: false,
                        per: 0,
                      };
                      return (
                        <div className="flex flex-1 items-center justify-center">
                          <div key={idx} className="text-base">
                            <input
                              type="radio"
                              name={`usage-${key}`}
                              checked={optionValue.per === idx}
                              onChange={() => handleUsageRateChange(key, idx)}
                              className="h-4 w-4 rounded-full border-2 border-neutral-400 text-cyan-700 accent-cyan-700"
                            />
                          </div>
                        </div>
                      );
                    })}
                  </div>
                </div>

                <div className="w-full">
                  <div className="justify-betweenpr-4 flex h-12">
                    <div className="flex-1 opacity-0">飼育室の換気回数</div>
                    {Object.entries(question.times || {}).map(
                      ([, timesValue], idx) => (
                        <div className="flex flex-1 items-center justify-center">
                          <div key={idx} className="text-base text-neutral-700">
                            {timesValue as string}
                          </div>
                        </div>
                      ),
                    )}
                  </div>
                  <div className="flex h-12 justify-between bg-neutral-100 pr-4">
                    <div className="flex-1 self-center text-base text-neutral-700">
                      飼育室の換気回数
                    </div>
                    {Object.entries(question.times || {}).map(([,], idx) => {
                      const optionValue = nestedValue[value] || {
                        isChecked: false,
                        times: 0,
                      };
                      return (
                        <div className="flex flex-1 items-center justify-center">
                          <div key={idx} className="text-base">
                            <input
                              type="radio"
                              name={`ventilation-${key}`}
                              checked={optionValue.times === idx}
                              onChange={() => handleVentilationChange(key, idx)}
                              className="h-4 w-4 rounded-full border-2 border-neutral-400 text-cyan-700 accent-cyan-700"
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
      });
    }

    return null;
  };

  return (
    <div className="flex flex-col gap-3">
      <div className="self-center text-sm font-bold text-cyan-700">
        設問&nbsp;{index + 1}
      </div>
      <p className="mb-4 border-b-2 border-dotted border-neutral-300 pb-2.5 text-base font-bold text-neutral-700">
        {question.title}
      </p>

      <div className="mb-9">{renderFormInputs()}</div>
      <Button
        className="self-center py-3 font-medium"
        onClick={(e) => {
          handleSubmit(e);

          if (index < 12) {
            setIndex(index + 1);
          }
        }}
        type="submit"
      >
        次の設問へ&nbsp;&nbsp;&rarr;
      </Button>
    </div>
  );
}

export default DiagnosisForm;
