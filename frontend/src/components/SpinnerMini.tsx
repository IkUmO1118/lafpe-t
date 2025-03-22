interface SpinnerMiniProps {
  message: string;
}

function SpinnerMini({ message }: SpinnerMiniProps) {
  return (
    <div className="flex items-center justify-center gap-5">
      <div
        className="h-5 w-5 animate-spin rounded-full border-2 border-solid border-cyan-50"
        style={{ borderTopColor: "transparent", borderTopWidth: "1.4px" }}
      ></div>
      <p className="text-base text-neutral-300">{message}</p>
    </div>
  );
}

export default SpinnerMini;
