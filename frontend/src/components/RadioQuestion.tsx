import { RadioScore } from "../types/diagnosis";

interface RadioQuestionProps {
  options: Record<string, string>;
  value: RadioScore;
  onChange: (newValue: RadioScore) => void;
  name: string;
  readOnly?: boolean;
}

function RadioQuestion({
  options,
  value,
  onChange,
  name = "radio",
  readOnly = false,
}: RadioQuestionProps) {
  const handleRadioChange = (optionIndex: number) => {
    if (readOnly) return;
    onChange(optionIndex);
  };

  return (
    <>
      {Object.entries(options).map(([key, optionText], optionIndex) => (
        <label key={key} className="flex h-12 items-center gap-2">
          <input
            type="radio"
            id={`option-${name}-${key}`}
            name={name}
            checked={value == optionIndex}
            onChange={() => handleRadioChange(optionIndex)}
            className="h-4 w-4 rounded-full border-2 border-neutral-400 text-cyan-700 accent-cyan-700"
            disabled={readOnly}
          />
          <span className="text-neutral-700">{optionText as string}</span>
        </label>
      ))}
    </>
  );
}

export default RadioQuestion;
