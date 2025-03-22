import {
  Radar,
  RadarChart,
  PolarGrid,
  PolarAngleAxis,
  ResponsiveContainer,
  Legend,
  PolarRadiusAxis,
} from "recharts";
import { TickItem } from "recharts/types/util/types";

// カスタム四角形マーカーコンポーネント
const renderSquareShape = (props: any) => {
  const { cx, cy, payload, index } = props;

  return (
    <rect
      key={`marker-${payload.id || index}`}
      x={cx - 4}
      y={cy - 4}
      width={8}
      height={8}
      fill="#0e7490"
    />
  );
};

// プロップスの型定義
interface PrincipleRadarChartProps {
  principle1?: number;
  principle2?: number;
  principle3?: number;
  principle4?: number;
  principle5?: number;
  dp?: number;
}

const PrincipleRadarChart = ({
  principle1,
  principle2,
  principle3,
  principle4,
  principle5,
  dp,
}: PrincipleRadarChartProps) => {
  // 修正したデータ - 基準値を全て5に統一、評価結果も10を最大とする範囲で調整
  const data = [
    { id: "principle1", principle: "原則1", 評価結果: principle1, 基準値: 5 },
    { id: "principle2", principle: "原則2", 評価結果: principle2, 基準値: 5 },
    { id: "principle3", principle: "原則3", 評価結果: principle3, 基準値: 5 },
    { id: "principle4", principle: "原則4", 評価結果: principle4, 基準値: 5 },
    { id: "principle5", principle: "原則5", 評価結果: principle5, 基準値: 5 },
    { id: "principleDP", principle: "DP", 評価結果: dp, 基準値: 5 },
  ];

  const customTicks: TickItem[] = [0, 2, 4, 6, 8, 10];

  return (
    <>
      <ResponsiveContainer width="100%" height="100%">
        <RadarChart cx="50%" cy="50%" outerRadius="70%" data={data}>
          <PolarGrid gridType="polygon" />
          <PolarAngleAxis dataKey="principle" />

          <PolarRadiusAxis
            domain={[0, 10]}
            ticks={customTicks}
            tick={{ fontSize: 0 }}
            axisLine={false}
            tickLine={false}
          />

          <Radar
            name="評価結果"
            dataKey="評価結果"
            stroke="#0e7490"
            strokeWidth={3}
            fillOpacity={0}
            dot={renderSquareShape}
            isAnimationActive={false}
            activeDot={false}
          />

          <Radar
            name="基準値"
            dataKey="基準値"
            stroke="#f97316"
            strokeWidth={2.5}
            fillOpacity={0}
            dot={false}
            isAnimationActive={false}
          />

          <Legend />
        </RadarChart>
      </ResponsiveContainer>
    </>
  );
};

export default PrincipleRadarChart;
