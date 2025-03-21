interface QuestionWrapperProps {
  title: string;
  number?: number;
  children: React.ReactNode;
  showNumber?: boolean;
}

export function QuestionWrapper({
  title,
  number,
  children,
  showNumber = true,
}: QuestionWrapperProps) {
  return (
    <div className="flex flex-col gap-3">
      {showNumber && (
        <div className="self-center text-sm font-bold text-cyan-700">
          設問&nbsp;{number}
        </div>
      )}
      <p className="mb-4 border-b-2 border-dotted border-neutral-300 pb-2.5 text-base font-bold text-neutral-700">
        {title}
      </p>
      <div className="mb-9">{children}</div>
    </div>
  );
}

export default QuestionWrapper;
