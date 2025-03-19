interface ProgressBarProps {
  index: number;
}

function ProgressBar({ index }: ProgressBarProps) {
  return (
    <div className="grid h-1.5 w-full grid-cols-13 gap-1.5">
      {Array.from({ length: 13 }, (_, i) => (
        <button
          key={i}
          className={`rounded-full ${
            i <= index ? "bg-cyan-700" : "bg-neutral-300"
          }`}
        ></button>
      ))}
    </div>
  );
}

export default ProgressBar;
