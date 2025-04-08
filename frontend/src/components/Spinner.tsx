function Spinner() {
  return (
    <div className="fixed inset-0 flex flex-col items-center justify-center gap-4 bg-white">
      <div className="relative">
        <div className="h-20 w-20 animate-spin rounded-full border-[6px] border-transparent border-r-cyan-700 border-b-cyan-700 border-l-cyan-700"></div>
      </div>
      <p className="animate-pulse text-cyan-700">読み込み中...</p>
    </div>
  );
}

export default Spinner;
