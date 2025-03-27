import { CheckboxScore } from "../types/diagnosis";

interface CheckboxQuestionProps {
  options: Record<string, string>;
  value: CheckboxScore;
  onChange: (newValue: CheckboxScore) => void;
  readOnly?: boolean;
  name?: string;
}

function CheckboxQuestion({
  options,
  value = [],
  onChange,
  readOnly = false,
  name = "checkbox",
}: CheckboxQuestionProps) {
  const checkedValues = Array.isArray(value) ? value : [];
  const handleCheckboxChange = (optionIndex: number) => {
    if (readOnly) return;

    if (value.includes(optionIndex)) {
      onChange(value.filter((val) => val !== optionIndex));
    } else {
      onChange([...value, optionIndex]);
    }
  };

  return (
    <>
      {Object.entries(options).map(([key, optionText], optionIndex) => (
        <label key={key} className="flex h-12 items-center gap-2">
          <input
            type="checkbox"
            id={`option-${name}-${key}`}
            checked={checkedValues.includes(optionIndex)}
            onChange={() => handleCheckboxChange(optionIndex)}
            className="h-4 w-4 rounded border-2 border-neutral-400 text-cyan-700 accent-cyan-700"
            disabled={readOnly}
          />
          <span className="text-neutral-700">{optionText as string}</span>
        </label>
      ))}
    </>
  );
}

export default CheckboxQuestion;
